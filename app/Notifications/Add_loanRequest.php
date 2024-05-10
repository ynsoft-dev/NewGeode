<?php

namespace App\Notifications;

use App\Models\LoanRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
class Add_loanRequest extends Notification
{
    use Queueable;
    private $loans;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoanRequest $loans)
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

            //'data' => $this->details['body']
            'id'=> $this->loans->id,
            'title'=>'Loan request added by:',
            'user'=> Auth::user()->name,

        ];
    }
}