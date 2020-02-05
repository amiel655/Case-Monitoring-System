<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransferClient extends Notification
{
    use Queueable;

    public $control_num;
    public $assigned_from;
    public $assigned_to;
    public $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $control_num, string $assigned_from, string $assigned_to, string $image)
    {
        $this->control_num = $control_num;
        $this->assigned_from = $assigned_from;
        $this->assigned_to = $assigned_to;
        $this->image = $image;
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
            'client_control_num' => $this->control_num,
            'client_assigned_from' => $this->assigned_from,
            'client_assigned_to' => $this->assigned_to,
            'client_image' => $this->image,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'client_control_num' => $this->control_num,
            'client_assigned_from' => $this->assigned_from,
            'client_assigned_to' => $this->assigned_to,
            'client_image' => $this->image,
        ]);
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
}
