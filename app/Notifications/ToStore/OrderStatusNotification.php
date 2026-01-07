<?php

namespace App\Notifications\ToStore;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderStatusNotification extends Notification implements ShouldQueue
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
        return ['database','broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line(__('Your order #:ref_id status has been updated to :status.', [
                        'ref_id' => $this->order->ref_id,
                        'status' => __($this->order->label()),
                    ]))
                    ->action(__('Order details'), url( 'orders/details/'. $this->order->id))

                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'ref_id' => $this->order->ref_id,
            'order_status' => __($this->order->label()),
            'order_id' => $this->order->id,
            'order_url' => route('customer.order.details', $this->order->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'ref_id' => $this->order->ref_id,
                'order_status' => __($this->order->label()),
                'order_id' => $this->order->id,
                'order_url' => route('customer.order.details', $this->order->id),
            ]
        ]);
    }
}
