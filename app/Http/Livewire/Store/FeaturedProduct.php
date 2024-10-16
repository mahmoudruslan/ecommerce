<?php

namespace App\Http\Livewire\Store;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class FeaturedProduct extends Component
{
    use LivewireAlert;
    public $products;
    public $quantity = 1;
    public $product;

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseQuantity($product_quantity)
    {
        if ($this->quantity < $product_quantity) {
            $this->quantity++;
        } else {
            $this->alert('success', __('This is the available quantity of the product.'));
        }
    }

    public function resetQuantity()
    {
        $this->quantity = 1;
    }
    public function addToWishList($product_id)
    {
        $items = \Cart::getContent()->pluck('id');
        if ($items->contains($product_id)) {
            $this->alert('error', __('This product is already in your wish list.'));
        } else {
            $product = Product::find($product_id);
            \Cart::session('wishList')->add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => $this->quantity,
            ]);
            $this->alert('success', __('Product added to wish list successfully.'));
        }
    }
    public function addToCart($product_id)
    {
        $items = \Cart::getContent()->pluck('id');
        if ($items->contains($product_id)) {
            $this->alert('error', __('This product is already in your cart.'));
        } else {
            $product = Product::find($product_id);
            \Cart::add(
                $product->id,
                $product['name_' . app()->getLocale()],
                $product->price,
                $this->quantity,
                array(
                    'name_ar' => $product->name_ar,
                    'name_en' => $product->name_en,
                )
            );
            $this->alert('success', __('Product added to cart successfully.'));
        }
    }
    public function render()
    {
        return view('livewire.store.featured-product', [
            'products' => $this->products
        ]);
    }
}
