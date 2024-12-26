<?php

namespace App\Notifications\ToDashboard;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'customer_id' => $this->order['order']['user_id'],
            'order_address_id' => $this->order['order']['order_address_id'],
            'user_address_id' => $this->order['order']['user_address_id'],
            'customer_name' => $this->order['first_name'] . ' ' . $this->order['last_name'],
            'order_id' => $this->order['id'],
            'amount' => $this->order['order']['total'],
            'order_url' => route('admin.orders.show', $this->order['id']),
            'created_at' => $this->order['order']['created_at']->format('M d, Y H:m:s'),

        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'customer_id' => $this->order['order']['user_id'],
                'order_address_id' => $this->order['order']['order_address_id'],
                'user_address_id' => $this->order['order']['user_address_id'],
                'customer_name' => $this->order['first_name'] . ' ' . $this->order['last_name'],
                'order_id' => $this->order['id'],
                'amount' => $this->order['order']['total'],
                'order_url' => route('admin.orders.show', $this->order['id']),
                'created_at' => $this->order['order']['created_at']->format('M d, Y H:m:s'),
            ]
        ]);
    }
}

