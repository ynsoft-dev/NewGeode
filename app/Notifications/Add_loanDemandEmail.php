<?php

namespace App\Notifications;

use App\Models\LoanDemand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Add_loanDemandEmail extends Notification
{
    use Queueable;
    private $loans;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoanDemand $loans)
    {
        $this->loans = $loans;
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
        $url = url('/loanDetails/'.$this->loans->id);
    
        return (new MailMessage)
            ->subject('New loan demand added')
            ->line('New loan demand added')
            ->action('Show demand', $url)
            ->line('Thank you for using BoxFlow !');
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