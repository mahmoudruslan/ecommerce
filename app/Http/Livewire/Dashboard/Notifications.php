<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Notifications extends Component
{

    public $unreadNotificationsCount;
    public $unreadNotifications;



    public function getListeners()
    {
        $auth_id = auth()->id();
        return [
            "echo-notification:App.Models.User.{$auth_id},notification" => 'updateNotifications'
        ];
    }

    public function updateNotifications($notification)
    {
        $this->mount();
    }
    public function mount()
    {
        $count_notify = auth()->user()->unreadNotifications()->count();
        $this->unreadNotificationsCount = $count_notify > 0 ? $count_notify : '';
        $this->unreadNotifications = auth()->user()->unreadNotifications()->get();
    }

    public function markAsRead($notify_id)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $notify_id)->first();
        $notification->markAsRead();
        return redirect()->to($notification->data['order_url']);

    }

    public function render()
    {
        return view('livewire.dashboard.notifications');
    }


}
