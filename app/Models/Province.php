<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    // protected $fillable = ['province_name', 'place_image'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
    public function requestTrip(){
        return $this->hasMany(RequestTrip::class);
    }

    public function tour(){
        return $this->hasMany(Tour::class);
    }
}
