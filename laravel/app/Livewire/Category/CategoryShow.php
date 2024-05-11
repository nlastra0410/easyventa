<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Ver categorias')]
class CategoryShow extends Component
{
    public Category $category;
    public function render()
    {
        return view('livewire.category.category-show');
    }
}
