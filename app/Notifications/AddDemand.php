<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddDemand extends Notification
{
    use Queueable;
    private $request_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($request_id)
    {
        $this->request_id = $request_id;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
    
        $url = url('/archiveDemandDetails/'.$this->request_id);
    
        // $url = 'http://127.0.0.1:8000/archieveDemandDetails/' . $this->request_id;
        return (new MailMessage)
            ->subject('New archive demand added')
            ->line('New archive demand added')
            ->action('Show demand', $url)
            ->line('Thank you for using NewGeode !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
