<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Signature extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'signature_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full URL to the signature image
     */
    public function getSignatureUrlAttribute(): string
    {
        foreach (['public', 'local'] as $disk) {
            $storage = Storage::disk($disk);
            if ($storage->exists($this->file_path)) {
                $mime = $storage->mimeType($this->file_path) ?: 'image/png';
                return 'data:' . $mime . ';base64,' . base64_encode($storage->get($this->file_path));
            }
        }

        return '';
    }

    /**
     * Get signature version at specific timestamp
     */
    public static function getVersionAtTime(int $userId, string $type, $timestamp)
    {
        return static::where('user_id', $userId)
            ->where('signature_type', $type)
            ->where('created_at', '<=', $timestamp)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
