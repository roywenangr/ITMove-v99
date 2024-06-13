<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryFrom extends Component
{
    public $categories;
    public $selectedCategory = null;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.category-from');
    }
}
