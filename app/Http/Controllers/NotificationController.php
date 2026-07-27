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
            ->get(['id', 'type', 'title', 'body', 'title_en', 'body_en', 'url', 'read_at', 'created_at']);

        return response()->json([
            'unread_count'  => $notifications->whereNull('read_at')->count(),
            'notifications' => $notifications->map(fn ($n) => [
                'id'         => $n->id,
                'type'       => $n->type,
                'title'      => app()->getLocale() === 'en' ? $this->englishTitle($n) : $n->title,
                'body'       => app()->getLocale() === 'en' ? $this->englishBody($n) : $n->body,
                'url'        => $this->notificationUrl($n),
                'is_read'    => $n->read_at !== null,
                'time_ago'   => $n->created_at->diffForHumans(),
            ]),
        ]);
    }

    private function englishTitle(Notification $notification): string
    {
        if ($notification->title_en && !str_starts_with($notification->title_en, 'Pengguna Baru:')) {
            return $notification->title_en;
        }

        if ($notification->type === 'user_created' && preg_match('/^Pengguna Baru: (.+)$/u', $notification->title, $matches)) {
            return __('Pengguna Baru: :name', ['name' => $matches[1]], 'en');
        }

        if (preg_match('/^(Latihan|Ujian|Quiz) Baru: (.+)$/u', $notification->title, $matches)) {
            $label = __($matches[1], [], 'en');
            return __(':label Baru: :title', ['label' => $label, 'title' => $matches[2]], 'en');
        }

        return $notification->title_en ?: $notification->title;
    }

    private function notificationUrl(Notification $notification): ?string
    {
        if (!$notification->url) {
            return null;
        }

        $isPractice = str_contains($notification->title, 'Latihan')
            || str_contains($notification->title, 'Exercise')
            || str_contains($notification->body, 'Latihan')
            || str_contains($notification->body, 'Exercise');

        return $notification->type === 'submission' && $isPractice
            ? str_replace('/quizzes/', '/practices/', $notification->url)
            : $notification->url;
    }

    private function englishBody(Notification $notification): string
    {
        if ($notification->body_en && !str_contains($notification->body_en, 'telah mengumpulkan') && !str_contains($notification->body_en, '\\"')) {
            return $notification->body_en;
        }

        $body = $notification->body;
        $label = match ($notification->type) {
            'practice_published' => __('Latihan', [], 'en'),
            'exam_published' => __('Ujian', [], 'en'),
            default => __('Quiz', [], 'en'),
        };

        if (preg_match('/^(?:Latihan|Ujian|Quiz) baru telah dipublikasikan di (.+)\. Mulai sekarang!$/u', $body, $matches)) {
            return __(':label baru telah dipublikasikan di :target. Mulai sekarang!', [
                'label' => $label,
                'target' => $matches[1],
            ], 'en');
        }

        if (preg_match('/^(.+?) telah mengumpulkan (?:Latihan|Ujian|Quiz) [\\"]?(.+?)[\\"]? di (.+)\.$/u', $body, $matches)) {
            return __(':name telah mengumpulkan :label ":title" di :course.', [
                'name' => $matches[1],
                'label' => $label,
                'title' => $matches[2],
                'course' => $matches[3],
            ], 'en');
        }

        if (preg_match('/^Akun (Instruktur|Admin|Peserta) baru atas nama (.+?) \((.+?)\) telah ditambahkan\.$/u', $body, $matches)) {
            return __('Akun :role baru atas nama :name (:email) telah ditambahkan.', [
                'role' => __($matches[1], [], 'en'),
                'name' => $matches[2],
                'email' => $matches[3],
            ], 'en');
        }

        return $notification->body_en ?: $body;
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

