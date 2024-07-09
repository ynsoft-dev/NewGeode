<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'url' => route('notifications.redirectToNotification', ['id' => $notification->id]),
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

        $dropdownHtml .= "<a href='" . route('notifications.markAsReadAll') . "' class='dropdown-item dropdown-footer'>Read All</a>";

        return [
            'label' => $unreadNotifications->count(),
            'label_color' => $unreadNotifications->count() > 0 ? 'danger' : 'success',
            'icon_color' => $unreadNotifications->count() > 0 ? 'dark' : 'dark',
            'dropdown' => $dropdownHtml,
        ];
    }

    public function markAsReadAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return redirect('/home');
    }

    public function markAsRead($id)
    {
        // Récupérer la notification par son ID
        $notification = auth()->user()->notifications->where('id', $id)->first();

        // Vérifier si la notification existe
        if ($notification) {
            // Marquer la notification comme lue en mettant à jour la valeur de 'read_at'
            $notification->markAsRead();

            // Mise à jour de la colonne 'read_at' dans la table 'notifications' directement
            DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);

            // Retourner une réponse JSON
            return response()->json(['message' => 'Notification marked as read']);
        } else {
            // Si la notification n'est pas trouvée, retourner une réponse d'erreur
            return response()->json(['error' => 'Notification not found'], 404);
        }
    }

    public function redirectToNotification($id)
    {
        // Récupérer la notification par son ID
        $notification = auth()->user()->notifications->where('id', $id)->first();

    
        // Vérifier si la notification existe
if ($notification) {
    // Marquer la notification comme lue
    $notification->markAsRead();

    // Mise à jour de la colonne 'read_at' dans la table 'notifications' directement
    DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);

    // Déterminer le type de la notification
    $notificationType = $notification->type;

    // Rediriger en fonction du type de notification
    if ($notificationType === 'App\Notifications\Add_loanDemand'|| $notificationType === 'App\Notifications\AddLoanResponse') {
        // Rediriger vers l'URL de détails de prêt
        return redirect(url('loanDetails/' . $notification->data['id']));
    } elseif ($notificationType === 'App\Notifications\AddArchiveResponse') {
        // Rediriger vers une autre URL
        return redirect(url('archiveDemandDetails/' . $notification->data['id']));
    } else {
        // Gérer le cas où le type de notification n'est pas reconnu
        return redirect()->back()->withErrors(['error' => 'Invalid notification type']);
    }
}

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