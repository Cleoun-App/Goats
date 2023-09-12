<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        try {

            $user = get_user($request->username);

            $request->validate([
                'status' => ['nullable', 'in:new,old,all']
            ]);

            $notifs = match($request->status ?? 'all') {
                "new" => $this->getUnreadNotification($user),
                "old" => $user->readNotifications,
                "all" => $user->notifications,
            };

            return ResponseFormatter::success(
                $notifs,
                count($notifs) === 0 ? "Ada tidak memiliki notifikasi!" : "Notifikasi berhasil didapatkan"
            );

        } catch (\Throwable $th) {
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function getUnreadNotification(User $user) {
        $notifs = $user->unreadNotifications;

        foreach($notifs as $notif) {
            $notif->markAsRead();
        }

        return $notifs;
    }
}
