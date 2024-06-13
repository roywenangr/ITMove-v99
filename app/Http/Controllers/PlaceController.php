<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function getPlaces($provinceId)
    {
        $places = Place::where('province_id', $provinceId)->get();
        return response()->json($places);
    }
}
