<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Charts extends Component
{
    public $monthLabels = [];
    public $monthValues = [];


    public function mount()
    {
        $orders = Order::
        select(DB::raw('SUM(total) as revenue'), DB::raw('EXTRACT(MONTH FROM created_at) as month'))
        ->whereStatus(Order::FINISHED)
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->pluck('revenue', 'month');
        foreach($orders->keys() as $month_number)
        {
            $this->monthLabels[] = date('F', mktime(0, 0,0, $month_number, 1));
        }
        $this->monthValues = $orders->values()->toArray();
    }
    public function render()
    {
        return view('livewire.dashboard.charts');
    }
}
