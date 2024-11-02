<?php

namespace App\View\Components\store;

use Illuminate\View\Component;

class addAddressForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $governorates)
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
        return view('components.store.add-address-form');
    }
}
