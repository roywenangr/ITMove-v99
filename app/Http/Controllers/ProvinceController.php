<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProvinceController extends Controller
{
    public function showAdmin()
    {
        return view('admin.province');
    }

    public function store(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            'provinceName' => 'required|max:255',
            'provinceImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('provinceImage')) {
            $image = $request->file('provinceImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/provinsi');
            $image->move($destinationPath, $imageName);

            // Simpan hanya nama file ke database
            $province = new Province;
            $province->province_name = $request->provinceName;
            $province->place_image = $imageName; // Hanya nama file
            $province->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data provinsi berhasil disimpan.'
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
        $columns = ['id', 'name', 'image']; // Sesuaikan dengan nama kolom di database Anda

        $totalData = Province::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $provinces = Province::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $provinces = Province::where('province_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Province::where('province_name', 'LIKE', "%{$search}%")->count();
        }

        $data = [];
        if (!empty($provinces)) {
            foreach ($provinces as $province) {
                $nestedData['id'] = $province->id;
                $nestedData['name'] = $province->province_name;
                $nestedData['action'] = '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $province->id . '">Edit</button>
                                         <button class="btn btn-sm btn-danger btn-delete" data-id="' . $province->id . '">Hapus</button>';
                $data[] = $nestedData;
            }
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
            'name' => 'required',
        ];

        if ($request->has('changeImage') && $request->changeImage == 'on') {
            $validationRules['provinceImage'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $request->validate($validationRules);

        $province = Province::find($id);
        $province->province_name = $request->name;

        if ($request->has('changeImage') && $request->changeImage == 'on') {
                    // Menghapus gambar jika ada
            $imageName = $province->place_image; // Sesuaikan dengan nama kolom di database Anda
            $imagePath = public_path('/images/provinsi/' . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            // Simpan gambar baru
            $imageName = time() . '.' . $request->provinceImage->extension();
            $request->provinceImage->move(public_path('/images/provinsi'), $imageName);
            $province->place_image = $imageName;
        }

        $province->save();

        return response()->json(['success' => 'Data berhasil diupdate']);
    }

    public function deleteData($id)
    {
        $province = Province::find($id);

        // Cek apakah data province ditemukan
        if (!$province) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Menghapus gambar jika ada
        $imageName = $province->place_image; // Sesuaikan dengan nama kolom di database Anda
        $imagePath = public_path('/images/provinsi/' . $imageName);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Menghapus data dari database
        $province->delete();

        return response()->json(['success' => 'Data dan gambar berhasil dihapus']);
    }
}
