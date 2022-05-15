<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInfluencer extends Notification
{
    use Queueable;

    private $influncerData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($influncerData)
    {
        $this->influncerData = $influncerData;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line($this->influncerData['name'])
    //                 ->action($this->influncerData['email'], url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase ($notifiable)
    {
        return [
            'msg'=>$this->influncerData['msg'],
            'type'=>$this->influncerData['type'],
            'id'=>$this->influncerData['id']
        ];
    }
}
