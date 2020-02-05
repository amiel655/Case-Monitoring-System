<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HearingIsNear extends Notification
{
    use Queueable;

    public $hearing_date;
    public $control_num;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $hearing_date, string $control_num)
    {
        $this->hearing_date = $hearing_date;
        $this->control_num = $control_num;
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
            'hearing_date' => $this->hearing_date,
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
            'hearing_date' => $this->hearing_date,
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
