<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\ArchiveDemand;

class AddArchiveResponse extends Notification
{
    use Queueable;
    private $request_id;
    private $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(ArchiveDemand $request_id , $type = 'archive')
    {
        $this->request_id = $request_id;
        $this->type = $type;
        
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
    public function toDatabase($notifiable)
    {
        return [

            // 'data' => $this->details['body'],
            'id'=> $this->request_id->id,
            'borrow'=> $this->request_id->demand_archive_id,
            'title'=>'Your demand has been treated',
            'user'=> Auth::user()->name,

        ];
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
