<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;

class FeaturedProduct extends Component
{
    public $featured_products;
    
    public function render()
    {
        return view('livewire.store.featured-product', [
            'featured_products' => $this->featured_products]);
    }
}
