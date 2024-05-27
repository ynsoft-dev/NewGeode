<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LoanDemand;
use Illuminate\Support\Facades\Auth;

class AddLoanResponse extends Notification
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
    public function via( $notifiable)
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
    public function toDatabase($notifiable)
    {
        return [

            // 'data' => $this->details['body'],
            'id'=> $this->loans->id,
            'borrow'=> $this->loans->borrow_id,
            'title'=>'Votre demande à été traité:',
            'user'=> Auth::user()->name,

        ];
    }
}