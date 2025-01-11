<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use Livewire\Component;

class Statistics extends Component
{
    public $earningMonthly = 0;
    public $earningAnnual = 0;
    public $newOrdersMonthly = 0;
    public $finishedOrdersMonthly = 0;
    public $newOrdersMonthlyPercentage = 0;
    public $finishedOrdersMonthlyPercentage = 0;

    public function mount()
    {
        $this->earningAnnual = Order::whereStatus(Order::FINISHED)->whereYear('created_at', date('Y'))->sum('total');
        $this->earningMonthly = Order::whereStatus(Order::FINISHED)->whereMonth('created_at', date('m'))->sum('total');
        $this->newOrdersMonthly = Order::whereStatus(Order::PENDING)->whereMonth('created_at', date('m'))->count();
        $this->finishedOrdersMonthly = Order::whereStatus(Order::FINISHED)->whereMonth('created_at', date('m'))->count();
        $this->newOrdersMonthlyPercentage = $this->newOrdersMonthly / max(Order::count(), 1) * 100;
        $this->finishedOrdersMonthlyPercentage = $this->finishedOrdersMonthly / max(Order::count(), 1) * 100;
    }

    public function render()
    {
        return view('livewire.dashboard.statistics');
    }
}
