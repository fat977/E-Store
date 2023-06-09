<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PlaceOrder extends Notification
{
    use Queueable;
    private $orders;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $orders)
    {
        //
        $this->orders = $orders;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
   

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'id'=> $this->orders->id,
            'title'=>'New order is added by',
            'user'=> Auth::user()->name,
        ];
    }
}
