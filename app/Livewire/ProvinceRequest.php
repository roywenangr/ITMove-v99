<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Province;

class ProvinceRequest extends Component
{
    public $provinces; // Untuk menyimpan daftar provinsi
    public $places;    // Untuk menyimpan daftar tempat
    public $selectedProvince = null; // ID provinsi terpilih

    public function mount()
    {
        $this->provinces = Province::all(); // Muat semua provinsi
        $this->places = collect(); // Inisialisasi koleksi kosong untuk tempat
    }

    public function render()
    {
        return view('livewire.province-request');
    }
}
