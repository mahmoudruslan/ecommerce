<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;


class Notifications extends Component
{
    public $unreadNotificationsCount = 0;
    public $unreadNotifications;

    public function getListeners()
    {
        $auth_id = auth()->id();
        return [
            "echo-notification:App.Models.User.{$auth_id},notification" => 'mount'
        ];
    }

    public function markAsRead($notify_id)
    {
        // dd(true);
        $notification = $this->unreadNotifications->where('id', $notify_id)->first();
        if ($notification) {
            $notification->markAsRead();
            // تحديث البيانات
            $this->mount();
        }
        return redirect()->to($notification->data['order_url']);
    }

    public function mount()
    {
        $count_notify = auth()->user()->unreadNotifications()->count();
        $this->unreadNotificationsCount = $count_notify > 0 ? $count_notify : '0';
        $this->unreadNotifications = auth()->user()->unreadNotifications()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.store.notifications');
    }
}
