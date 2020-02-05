<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransferCase extends Notification
{
    use Queueable;

    public $case_no;
    public $assigned_from;
    public $assigned_to;
    public $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $case_no, string $assigned_from, string $assigned_to, string $image)
    {
        $this->case_no = $case_no;
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
            'case_no' => $this->case_no,
            'assigned_from' => $this->assigned_from,
            'assigned_to' => $this->assigned_to,
            'image' => $this->image,
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
            'case_no' => $this->case_no,
            'assigned_from' => $this->assigned_from,
            'assigned_to' => $this->assigned_to,
            'image' => $this->image,
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
