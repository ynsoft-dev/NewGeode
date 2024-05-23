<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotificationsData(Request $request)
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications;

        $notifications = [];
        foreach ($unreadNotifications as $notification) {
            $notifications[] = [
                'icon' => 'fas fa-fw fa-envelope',
                'text' => $notification->data['borrow'] . ' by ' . $notification->data['user'],
                'time' => $notification->created_at->diffForHumans(),
                'url' => url('loanDetails/' . $notification->data['id']),
            ];
        }

        $dropdownHtml = '';
        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";
            $time = "<span class='float-right text-muted text-sm'>{$not['time']}</span>";
            $dropdownHtml .= "<a href='{$not['url']}' class='dropdown-item'>{$icon}{$not['text']}{$time}</a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        if (count($notifications) > 0) {
            $dropdownHtml .= "<div class='dropdown-divider'></div>";
        }

        $dropdownHtml .= "<a href='".route('notifications.markAsReadAll')."' class='dropdown-item dropdown-footer'>Read All</a>";

        return [
            'label' => $unreadNotifications->count(),
            'label_color' => $unreadNotifications->count() > 0 ? 'danger' : 'success',
            'icon_color' => $unreadNotifications->count() > 0 ? 'dark' : 'light',
            'dropdown' => $dropdownHtml,
        ];
    }

    public function markAsReadAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        
        dd($user->unread_notifications_count);
        $notification = $user->unreadNotifications->find($id);
        if ($notification) {
            $notification->markAsRead();
            // Appel à la méthode pour décrémenter le compteur de notifications non lues
            $user->decrementUnreadNotificationsCount;
        }

        return redirect(url('loanDetails/' . $id));
    }

    public function unreadNotificationsCount()
    {
        return response()->json([
            'count' => Auth::user()->unreadNotifications->count()
        ]);
    }

    public function unreadNotifications()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        $notifications = [];
        
        foreach ($unreadNotifications as $notification) {
            $notifications[] = [
                'borrow' => $notification->data['borrow'],
                'user' => $notification->data['user'],
                'created_at' => $notification->created_at->diffForHumans(),
                'id' => $notification->id
            ];
        }
        
        return response()->json($notifications);
    }
}
