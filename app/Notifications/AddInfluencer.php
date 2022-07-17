<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInfluencer extends Notification
{
    use Queueable;

    private $influencerData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($influencerData)
    {
        $this->influencerData = $influencerData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
       return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase ($notifiable)
    {
        return [
            'title'     => $this->influencerData['title'] ?? '',
            'msg'       => $this->influencerData['msg'],
            'type'      => $this->influencerData['type'],
            'id'        => $this->influencerData['id'],
            'not_id'    => $this->id,
            'params'    => $this->influencerData['params'] ?? []
        ];
    }
}
