<?php

namespace App\View\Components\store;

use Illuminate\View\Component;

class viewProducts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public  $products, public $class)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.store.view-products');
    }
}
