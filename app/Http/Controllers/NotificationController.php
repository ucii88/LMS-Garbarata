<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Ambil notifikasi milik user yang login (untuk polling frontend).
     * Kembalikan JSON: { unread_count, notifications[] }
     */
    public function index()
    {
        // Sekalian bersihkan notif lama (30 hari) — dilakukan peluang ~5%
        if (rand(1, 20) === 1) {
            Notification::pruneOld();
        }

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByRaw('read_at IS NOT NULL')   // unread dulu
            ->orderByDesc('created_at')
            ->limit(20)
            ->get(['id', 'type', 'title', 'body', 'url', 'read_at', 'created_at']);

        return response()->json([
            'unread_count'  => $notifications->whereNull('read_at')->count(),
            'notifications' => $notifications->map(fn ($n) => [
                'id'         => $n->id,
                'type'       => $n->type,
                'title'      => $n->title,
                'body'       => $n->body,
                'url'        => $n->url,
                'is_read'    => $n->read_at !== null,
                'time_ago'   => $n->created_at->diffForHumans(),
            ]),
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);

        $notification->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    /**
     * Tandai semua notifikasi user sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
