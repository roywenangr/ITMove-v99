<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DestinationController extends Controller
{
    public function showAdmin()
    {
        $provinces = Province::all();

        return view('admin.destination', compact('provinces'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'placeName' => 'required|max:255',
            'placeImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'provinceId' => 'required',
        ]);

        // Handle file upload
        if ($request->hasFile('placeImage')) {
            $image = $request->file('placeImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/destination');
            $image->move($destinationPath, $imageName);

            // Simpan hanya nama file ke database
            $place = new Place;
            $place->place_name = $request->placeName;
            $place->place_image = $imageName; // Hanya nama file
            $place->province_id = $request->provinceId;
            $place->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data destinasi berhasil disimpan.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data, gambar tidak ditemukan.'
            ]);
        }
    }
    public function getData(Request $request)
    {
        $columns = ['id', 'name', 'province_name']; // Sesuaikan dengan nama kolom di tabel place dan province

        $totalData = Place::count();
        $totalFiltered = $totalData;


        $limit = $request->input('length') ?? 10; // Memberikan nilai default jika tidak ada
        $start = $request->input('start') ?? 0; // Memberikan nilai default jika tidak ada
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id'; // Menggunakan 'id' sebagai default
        $dir = $request->input('order.0.dir') ?? 'asc'; // Menggunakan 'asc' sebagai default

        $query = Place::select('places.id', 'places.place_name', 'provinces.province_name', 'provinces.id as province_id')
            ->leftJoin('provinces', 'places.province_id', '=', 'provinces.id');

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($query) use ($search) {
                $query->where('places.place_name', 'LIKE', "%{$search}%")
                    ->orWhere('provinces.province_name', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $query->count();
        }

        $query->orderBy($order, $dir);

        $dunkis = $query->offset($start)
            ->limit($limit)
            ->get();

        $data = [];
        if (!empty($dunkis)) {
            $no = $start + 1;
            foreach ($dunkis as $dunki) {
                $nestedData['id'] = $dunki->id;
                $nestedData['no'] = $no++;
                $nestedData['name'] = $dunki->place_name;
                $nestedData['province'] = $dunki->province_name;
                $nestedData['provinceId'] = $dunki->province_id;
                $nestedData['action'] = '<button class="btn btn-sm btn-warning btn-edit mb-2" data-id="' . $dunki->id . '">Edit</button>
                                         <button class="btn btn-sm btn-danger btn-delete mb-2" data-id="' . $dunki->id . '">Hapus</button>';
                $data[] = $nestedData;
            }
        } else {
            $data = null;
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }


    public function updateData(Request $request, $id)
    {
        $validationRules = [
            'place_name' => 'required',
        ];

        if ($request->has('changeImage') && $request->changeImage == 'on') {
            $validationRules['place_image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }


        $place = Place::find($id);
        $place->place_name = $request->place_name;

        if ($request->province_id != null) {
            $place->province_id = $request->province_id;
        }

        $request->validate($validationRules);;

        if ($request->has('changeImage') && $request->changeImage == 'on') {

            $imageName = $place->place_image; // Sesuaikan dengan nama kolom di database Anda
            $imagePath = public_path('/images/destination/' . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->place_image->extension();
            $request->place_image->move(public_path('/images/places'), $imageName);
            $place->place_image = $imageName;
        }

        $place->save();

        return response()->json(['success' => 'Data berhasil diupdate']);
    }
    public function deleteData($id)
    {
        $places = Place::find($id);

        // Cek apakah data province ditemukan
        if (!$places) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Menghapus gambar jika ada
        $imageName = $places->place_image; // Sesuaikan dengan nama kolom di database Anda
        $imagePath = public_path('/images/destination/' . $imageName);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Menghapus data dari database
        $places->delete();

        return response()->json(['success' => 'Data dan gambar berhasil dihapus']);
    }
}
