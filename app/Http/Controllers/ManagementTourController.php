<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Place;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManagementTourController extends Controller
{
    public function showAdmin()
    {

        $provinces = Province::all();

        return view('admin.manageTour', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'province' => 'required',
            'place' => 'required',
            'price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'max_slot' => 'required|numeric',
            'description' => 'required|min:5',
            'include' => 'required|min:5',
            'itinerary' => 'required|min:5',
            'highlights' => 'required|min:5',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data, pastikan semua data terisi dengan benar.',
                'errors' => $validator->errors()
            ]);
        }

        try {

            $tour = new Tour;

            $tour->tour_title = $request->title;
            $tour->province_id = $request->province;
            $tour->description = $request->description;
            $tour->max_slot = $request->max_slot;
            $tour->start_date = $request->start_date;
            $tour->end_date = $request->end_date;
            $tour->highlights = $request->description; // Note: This is the same as description. Is this intended?
            $tour->include = $request->include;
            $tour->not_include = $request->description; // Note: Again, this is the same as description.
            $tour->itinerary = $request->itinerary;
            $tour->price = preg_replace('/\D/', '', $request->price);

            $tour->save();

            $tour_id = DB::table('tours')->latest('id')->first()->id;
            foreach ($request->place as $placeid) {
                DB::table('tour_places')->insert([
                    'tour_id' => $tour_id,
                    'place_id' => $placeid
                ]);
            }

            foreach ($request->category as $categoryid) {
                DB::table('tour_categories')->insert([
                    'tour_id' => $tour_id,
                    'category_id' => $categoryid
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data tour berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }


    public function getData(Request $request)
    {
        $columns = ['id', 'tour_title', 'province_name', 'start_date', 'end_date', 'price'];

        $limit = $request->input('length') ?? 10; // Memberikan nilai default jika tidak ada
        $start = $request->input('start') ?? 0; // Memberikan nilai default jika tidak ada
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id'; // Menggunakan 'id' sebagai default
        $dir = $request->input('order.0.dir') ?? 'asc'; // Menggunakan 'asc' sebagai default

        $query = Tour::with(['tour_places.place', 'province']) // Eager loading
            ->leftJoin('provinces', 'tours.province_id', '=', 'provinces.id')
            ->select('tours.*', 'provinces.province_name'); // Memastikan memilih kolom yang diperlukan

        if ($search = $request->input('search.value')) {
            $query->where(function ($query) use ($search) {
                $query->where('tours.tour_title', 'LIKE', "%{$search}%")
                    ->orWhere('provinces.province_name', 'LIKE', "%{$search}%")
                    ->orWhere('tours.price', 'LIKE', "%{$search}%");
            });
        }

        $totalData = Tour::count();
        $totalFiltered = $search ? $query->count() : $totalData;

        $tours = $query->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = $tours->map(function ($tour, $key) use ($start) {
            $destinationNames = $tour->tour_places->map(function ($tourPlace) {
                return $tourPlace->place->place_name ?? 'N/A'; // Menangani kasus jika place_name tidak ada
            })->join(', ');

            $status =  $tour->is_public ? 'Publish' : 'Draft';
            $statuColor = $tour->is_public ? 'badge badge-lg bg-success' : 'badge badge-lg bg-warning';
            return [
                'id' => $tour->id,
                'name' => $tour->tour_title,
                'destination' => $destinationNames,
                'max_slot' => $tour->max_slot,
                'start_date' => $tour->start_date,
                'end_date' => $tour->end_date,
                'price' => 'Rp.' . number_format($tour->price),
                'description' => $tour->description,
                'highlights' => $tour->highlights,
                'include' => $tour->include,
                'not_include' => $tour->not_include,
                'itinerary' => $tour->itinerary,
                'is_public' => $tour->is_public,
                'provinsiId' => $tour->province->id ?? 'N/A',
                'destinationId' => $tour->tour_places->map(function ($tourPlace) {
                    return $tourPlace->place->id ?? 'N/A'; // Menangani kasus jika place_name tidak ada
                })->toArray(),
                'status' => '<span class="badge badge-lg ' . $statuColor . '">' . $status . '</span>',
                'action' => '<button class="btn btn-sm btn-info btn-edit mb-2" data-id="' . $tour->id . '">Edit</button>
                         <button class="btn btn-sm btn-danger btn-delete mb-2" data-id="' . $tour->id . '">Hapus</button>'
            ];
        });

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }


    public function updateData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'max_slot' => 'required|numeric',
            'description' => 'required|min:5',
            'include' => 'required|min:5',
            'itinerary' => 'required|min:5',
            'highlights' => 'required|min:5',
            'publish' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate data, pastikan semua data terisi dengan benar.',
                'errors' => $validator->errors()
            ]);
        }

        try {
            $tour = Tour::find($id);

            // Update data tour
            $tour->tour_title = $request->title;
            $tour->description = $request->description;
            $tour->max_slot = $request->max_slot;
            $tour->start_date = $request->start_date;
            $tour->end_date = $request->end_date;
            $tour->highlights = $request->highlights;
            $tour->include = $request->include;
            $tour->not_include = $request->not_include;
            $tour->itinerary = $request->itinerary;
            $tour->is_public = $request->publish;
            $tour->price = preg_replace('/\D/', '', $request->price);

            $tour->save();

            // Update relasi dengan places
            DB::table('tour_categories')->where('tour_id', $id)->delete();
            foreach ($request->category as $categoryid) {
                DB::table('tour_categories')->insert([
                    'tour_id' => $id,
                    'category_id' => $categoryid
                ]);
            }
            DB::table('tour_places')->where('tour_id', $id)->delete();
            foreach ($request->place as $placeid) {
                DB::table('tour_places')->insert([
                    'tour_id' => $id,
                    'place_id' => $placeid
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data tour berhasil diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function getDataById(Request $request, $id)
    {
        $tour = Tour::with(['tour_places.place', 'province'])
            ->leftJoin('provinces', 'tours.province_id', '=', 'provinces.id')
            ->select('tours.*', 'provinces.province_name')
            ->where('tours.id', $id)
            ->first();

        if (!$tour) {
            return response()->json(['error' => 'Tour not found'], 404);
        }

        $destinationNames = $tour->tour_places->map(function ($tourPlace) {
            return $tourPlace->place->place_name ?? 'N/A';
        })->join(', ');

        $status =  $tour->is_public ? 'Publish' : 'Draft';
        $statusColor = $tour->is_public ? 'badge badge-lg bg-success' : 'badge badge-lg bg-warning';

        $data = [
            'id' => $tour->id,
            'name' => $tour->tour_title,
            'destination' => $destinationNames,
            'max_slot' => $tour->max_slot,
            'start_date' => $tour->start_date,
            'end_date' => $tour->end_date,
            'price' => 'Rp.' . number_format($tour->price),
            'description' => $tour->description,
            'highlights' => $tour->highlights,
            'include' => $tour->include,
            'not_include' => $tour->not_include,
            'itinerary' => $tour->itinerary,
            'is_public' => $tour->is_public,
            'provinsiId' => $tour->province->id ?? 'N/A',
            'destinationId' => $tour->tour_places->map(function ($tourPlace) {
                return $tourPlace->place->id ?? 'N/A';
            })->toArray(),
            'status' => '<span class="badge badge-lg ' . $statusColor . '">' . $status . '</span>',
            'action' => '<button class="btn btn-sm btn-info btn-edit mb-2" data-id="' . $tour->id . '">Edit</button>
                     <button class="btn btn-sm btn-danger btn-delete mb-2" data-id="' . $tour->id . '">Hapus</button>'
        ];

        return response()->json($data);
    }


    public function deleteData($id)
    {
        try {
            $tour = Tour::find($id);

            // Delete related records if necessary
            DB::table('tour_places')->where('tour_id', $id)->delete();
            DB::table('tour_categories')->where('tour_id', $id)->delete();

            // Delete the tour itself
            $tour->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data tour berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}
