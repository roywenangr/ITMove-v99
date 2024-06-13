<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Tour;
use App\Models\Place;
use App\Models\Province;
use App\Models\RequestTrip;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\RequestPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReqTripController extends Controller
{


    public function index(Request $request)
    {
        $trips = new stdClass();
        $trips->total_guest = null;
        $trips->max_price = null;
        $trips->start_date = null;
        $trips->end_date = null;
        $trips->trip_plan = null;
        $trips->province_id = null;
        $trips_place = null;
        $province = Province::all();

        //  return view('addTour', compact('province','category'));
        return view('requestTrip', compact('trips', 'province', 'trips_place'));
    }

    public function inbox()
    {
        return view('inbox');
    }

    public function store(Request $request)
    {
        // Aturan validasi
        $rules = [
            'total_guest' => 'required|numeric|min:2|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'trip_plan' => 'required|string',
            'price' => 'required',
            'province' => 'required',
            'place' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        // Mengecek validasi dan mengembalikan error jika ada
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 422));
        }

        // Proses penyimpanan data
        $tripRequest = new RequestTrip; // Ganti dengan model yang sesuai
        $tripRequest->user_id = Auth::user()->id; // asumsikan pengguna terautentikasi
        $tripRequest->total_guest = $request->total_guest;
        $tripRequest->start_date = $request->start_date;
        $tripRequest->end_date = $request->end_date;
        $tripRequest->trip_plan = $request->trip_plan;
        $tripRequest->max_price = preg_replace('/\D/', '', $request->price);
        $tripRequest->province_id = $request->province;
        $tripRequest->status_id = 1;
        $tripRequest->request_date = date('Y-m-d');
        // Proses dan simpan data tambahan yang diperlukan
        $tripRequest->save();


        $request_id = DB::table('request_trips')->latest('id')->first()->id;

        foreach ($request->place as $placeid) {
            DB::table('request_places')->insert([
                'request_id' => $request_id,
                'place_id' => $placeid
            ]);
        }

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan trip berhasil disimpan.'
        ]);
    }

    public function apiInboxAll()
    {
        $query = RequestTrip::query();
        $inbox = $query->where('user_id', Auth::user()->id)->get();

        foreach ($inbox as $requestTrip) {
            $requestPlaces = RequestPlace::where('request_id', $requestTrip->id)->get();
            $places = collect(); // Koleksi untuk menyimpan data tempat terkait

            foreach ($requestPlaces as $req) {
                $place = Place::find($req->place_id);
                if ($place) {
                    $places->push($place); // Menambahkan tempat ke dalam koleksi
                }
            }

            // Menambahkan koleksi tempat ke dalam objek requestTrip
            $requestTrip->places = $places;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil.',
            'data' => $inbox // $inbox sekarang berisi informasi request dan place terkait
        ]);
    }


    public function adminInbox()
    {

        return view('admin.managerequest');
    }


    public function adminApiInboxAll(Request $request)
    {
        // Tentukan kolom yang akan digunakan untuk pengurutan dan pencarian
        $columns = ['request_trips.id', 'users.name', 'users.email', 'users.phonenumber', 'request_trips.total_guest', 'request_trips.max_price', 'request_trips.trip_plan', 'request_trips.start_date', 'request_trips.end_date', 'request_trips.request_date', 'request_trips.invoice'];

        // Menerima input dari request untuk paginasi, pengurutan, dan pencarian
        $limit = $request->input('length') ?? 10;
        $start = $request->input('start') ?? 0;
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'request_trips.id';
        $dir = $request->input('order.0.dir') ?? 'asc';

        // Membuat query utama
        $query = RequestTrip::with(['user', 'province'])
            ->leftJoin('users', 'request_trips.user_id', '=', 'users.id')
            ->leftJoin('provinces', 'request_trips.province_id', '=', 'provinces.id')
            ->select('request_trips.*', 'provinces.province_name', 'users.name as user_name', 'users.email', 'users.phonenumber')
            ->distinct();

        // Menambahkan kondisi pencarian jika ada input pencarian
        if ($search = $request->input('search.value')) {
            $query->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('users.phonenumber', 'LIKE', "%{$search}%")
                    ->orWhere('request_trips.total_guest', 'LIKE', "%{$search}%")
                    ->orWhere('request_trips.max_price', 'LIKE', "%{$search}%")
                    ->orWhere('request_trips.trip_plan', 'LIKE', "%{$search}%");
            });
        }

        // Hitung total data dan total data yang difilter
        $totalData = $query->count();
        $inbox = $query->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        // Memetakan data untuk respons
        $data = $inbox->map(function ($item) {
            // Contoh mendapatkan nama tempat (sesuaikan dengan struktur data Anda)
            $destinationNames = $item->places->map(function ($place) {
                // Anda bisa menambahkan detail tambahan dari $place di sini jika diinginkan
                return $place->place->place_name ?? 'N/A';
            })->join(', '); // Menggabungkan nama-nama tempat dengan koma

            // Logika untuk status dan warna status
            $status = 'Unknown';
            $statusColor = 'badge text-bg-secondary';
            if ($item->status_id == 1) {
                $status = 'Waiting for Approval';
                $statusColor = 'badge text-bg-warning';
                $respond = "dark";
                $disabled = "";
            } elseif ($item->status_id == 2) {
                $status = 'Approved';
                $statusColor = 'badge text-bg-success';
                $respond = "success";
                $disabled = "disabled";
            } elseif ($item->status_id == 3) {
                $status = 'Rejected';
                $statusColor = 'badge text-bg-danger';
                $respond = "danger";
                $disabled = "disabled";
            }

            return [
                'id' => $item->id,
                'name' => $item->user_name,
                'email' => $item->email,
                'phonenumber' => $item->phonenumber,
                'total_guest' => $item->total_guest,
                'max_price' => 'Rp.' . number_format($item->max_price),
                'trip_plan' => $item->trip_plan,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'request_date' => $item->request_date,
                'invoice' => $item->invoice,
                'destination' => $destinationNames,
                'status' => '<span class="' . $statusColor . '  badge-lg ">' . $status . '</span>',
                'action' => '<button class="btn btn-sm btn-respond btn-' . $respond . ' mb-2" data-id="' . $item->id . '" ' . $disabled . '>Respond</button>
                <button class="btn btn-sm btn-info btn-detail mb-2" data-id="' . $item->id . '">Detail</button>'
            ];
        });

        // Mengembalikan data dalam format JSON
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalData, // Atau jumlah data setelah filter, jika diperlukan
            "data" => $data
        ]);
    }

    public function creatInvoice(Request $request, $info)
    {

        if ($info == "approve") {

            $id_request_trip = $request->id;

            $request_trip = RequestTrip::find($id_request_trip);

            $transactionId = 'TRX-' . date('YmdHis') . '-' . Str::random(6);

            Transaction::create([
                'trx_id' => $transactionId,
                'user_id' => $request_trip->user_id,
                'total_price' => $request_trip->max_price,
                'status' => 'Unpaid'
            ]);

        }else{

        }
    }
}
