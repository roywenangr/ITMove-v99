<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $tours = Tour::all()->where('is_public', 1)->shuffle()->take(4);
        $poupular = Province::all()->shuffle()->take(3);
        $prov = Province::all();

        $join = DB::table('transaction_details')
        ->select('tours.province_id', DB::raw('SUM(quantity) as count'))
        ->join('tours', 'transaction_details.tour_id', '=', 'tours.id')
        ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
        ->where('transactions.status', 'Paid')
        ->where('tours.is_public', '1')
        ->groupBy('tours.province_id')
        ->orderBy('count','desc')
        ->get();

        $province = array();
        $count = 0;

        if(count($province) < 3){
            $remainingProv = $prov->diff($province);
            foreach($remainingProv as $provinceAdd) {
                if(count($province) < 3){
                    array_push($province, $provinceAdd);
                }
            }
        }

        return view('home', compact('tours', 'poupular', 'province'));

    }
    public function guide()
    {
        return view('guide');
    }
    public function about()
    {
        return view('about');
    }
}
