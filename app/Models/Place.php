<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function requestPlace(){
        return $this->hasMany(RequestPlace::class);
    }
}
