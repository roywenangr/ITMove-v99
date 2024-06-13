<?php

namespace App\Livewire;

use App\Models\Place;
use Livewire\Component;
use App\Models\Province;

class ProvinceForm extends Component
{

    public $provinces; // Untuk menyimpan daftar provinsi
    public $places;    // Untuk menyimpan daftar tempat
    public $selectedProvince = null; // ID provinsi terpilih

    public function mount()
    {
        $this->provinces = Province::all(); // Muat semua provinsi
        $this->places = collect(); // Inisialisasi koleksi kosong untuk tempat
    }

    public function updatedSelectedProvince($province)
    {
        $this->places = Place::where('id', $province)->get();
        logger('Places loaded:', $this->places->toArray()); // Untuk debugging
    }

    public function render()
    {
        return view('livewire.province-form');
    }
}
