<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPlace extends Model
{
    use HasFactory;

    public function requestTrip(){
        return $this->belongsTo(RequestTrip::class,'request_trip_id');
    }

    public function place() {
        return $this->belongsTo(Place::class);
    }
    public function places()
    {
        return $this->hasMany(RequestPlace::class, 'request_id');
    }

}
