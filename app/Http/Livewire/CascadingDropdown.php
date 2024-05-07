<?php

namespace App\Http\Livewire;

use App\Models\City;
use Livewire\Component;

class CascadingDropdown extends Component
{
    public $governorates,$governorate_id,$city_id, $user_address, $cities = [];
    

    public function mount($governorates, $user_address)
    {
        $this->governorates = $governorates;
        $this->user_address = $user_address;
        
    }

    public function render()
    {
        if(!empty($this->governorate_id)) {
            $this->cities = City::where('governorate_id', $this->governorate_id)->get();
        }else{
            $this->reset(['cities']);
        }
        return view('livewire.cascading-dropdown', [
            'governorates' => $this->governorates,
            'cities' => $this->cities,
        ]);
    }
}
