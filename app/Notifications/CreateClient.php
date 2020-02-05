<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CreateClient extends Notification
{
    use Queueable;

    public $assigned_by;
    public $assigned_by_image;
    public $control_num;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $assigned_by, string $assigned_by_image, string $control_num)
    {
        $this->assigned_by = $assigned_by;
        $this->control_num = $control_num;
        $this->assigned_by_image = $assigned_by_image;
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
            'assigned_by' => $this->assigned_by,
            'assigned_by_image' => $this->assigned_by_image,
            'control_num' => $this->control_num,
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
            'assigned_by' => $this->assigned_by,
            'assigned_by_image' => $this->assigned_by_image,
            'control_num' => $this->control_num,
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
