<?php

namespace App\Notifications\ToStore;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $order;
    private $attach;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $attach)
    {
        $this->order = $order;
        $this->attach = $attach;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['broadcast', 'database'];
        if ($notifiable->receive_emails == 1) {
            $via[] = 'mail';
        }
        return $via;

    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Dear, ' . $notifiable->fullName)
                    ->line('Thank you for using our application!')
                    ->attach($this->attach, [
                        'as' => 'invoice.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'ref_id' => $this->order->ref_id,
            'order_status' => __($this->order->status()),
            'order_id' => $this->order->id,
            'order_url' => route('customer.order.details', $this->order->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'ref_id' => $this->order->ref_id,
                'order_status' => __($this->order->status()),
                'order_id' => $this->order->id,
                'order_url' => route('customer.order.details', $this->order->id),
            ]
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
