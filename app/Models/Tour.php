<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_title',
        'province_id',
        'description',
        'max_slot',
        'start_date',
        'end_date',
        'highlights',
        'include',
        'itinerary',
        'price'
        // Tambahkan kolom lain yang diperlukan
    ];

    // protected $dates = ['start_date', 'end_date'];

    // protected $casts = [
    //     'start_date' => 'datetime',
    //     'end_date' => 'datetime',
    // ];

    public function tourCategory(){
        return $this->hasMany(TourCategory::class);
    }

    public function tour_places() {
        return $this->hasMany(TourPlace::class);
    }

    public function tourPlace(){
        return $this->hasMany(TourPlace::class);
    }

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class);
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }
}
