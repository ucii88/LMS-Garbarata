<?php

namespace App\Services;

use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class SignatureService
{
    /**
     * Save signature from canvas data (base64)
     *
     * @param User $user
     * @param string $base64Data
     * @param string $type
     * @return Signature
     * @throws InvalidArgumentException
     */
    public function saveFromCanvas(User $user, string $base64Data, string $type): Signature
    {
        // Validate signature type
        if (!in_array($type, ['instructor', 'kepala_training'])) {
            throw new InvalidArgumentException('Invalid signature type. Must be instructor or kepala_training.');
        }

        // Decode base64 image - remove data URI scheme if present
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));
        
        if ($imageData === false) {
            throw new InvalidArgumentException('Invalid base64 image data.');
        }

        // Generate unique filename with timestamp for versioning
        $filename = sprintf(
            '%s_%s_%s.png',
            $type,
            $user->id,
            now()->timestamp
        );
        
        $path = "signatures/{$filename}";
        
        // Store the signature image
        Storage::disk('public')->put($path, $imageData);
        
        // Create signature record
        return Signature::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_name' => $filename,
            'signature_type' => $type,
        ]);
    }

    /**
     * Save signature from uploaded file
     *
     * @param User $user
     * @param UploadedFile $file
     * @param string $type
     * @return Signature
     * @throws InvalidArgumentException
     */
    public function saveFromFile(User $user, UploadedFile $file, string $type): Signature
    {
        // Validate signature type
        if (!in_array($type, ['instructor', 'kepala_training'])) {
            throw new InvalidArgumentException('Invalid signature type. Must be instructor or kepala_training.');
        }

        // Validate file
        $this->validateSignatureFile($file);
        
        // Generate unique filename with timestamp
        $filename = sprintf(
            '%s_%s_%s.%s',
            $type,
            $user->id,
            now()->timestamp,
            $file->getClientOriginalExtension()
        );
        
        $path = $file->storeAs('signatures', $filename, 'public');
        
        return Signature::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'signature_type' => $type,
        ]);
    }

    /**
     * Get current signature for user
     *
     * @param User $user
     * @param string $type
     * @return Signature|null
     */
    public function getCurrentSignature(User $user, string $type): ?Signature
    {
        return Signature::where('user_id', $user->id)
            ->where('signature_type', $type)
            ->latest('created_at')
            ->first();
    }

    public function toDataUri(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        foreach (['public', 'local'] as $disk) {
            $storage = Storage::disk($disk);
            if ($storage->exists($path)) {
                $mime = $storage->mimeType($path) ?: 'image/png';
                return 'data:' . $mime . ';base64,' . base64_encode($storage->get($path));
            }
        }

        return null;
    }

    /**
     * Get signature at specific timestamp (for historical certificates)
     *
     * @param int $userId
     * @param string $type
     * @param mixed $timestamp
     * @return Signature|null
     */
    public function getSignatureAtTime(int $userId, string $type, $timestamp): ?Signature
    {
        return Signature::getVersionAtTime($userId, $type, $timestamp);
    }

    /**
     * Validate signature file
     *
     * @param UploadedFile $file
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateSignatureFile(UploadedFile $file): void
    {
        // Check file size - max 5MB
        $maxSizeKB = 5 * 1024; // 5MB in KB
        
        if ($file->getSize() > $maxSizeKB * 1024) {
            throw new InvalidArgumentException('File size exceeds maximum allowed size of 5MB.');
        }
        
        // Check mime type - only PNG and JPG/JPEG allowed
        $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new InvalidArgumentException('Invalid file format. Only PNG and JPG images are allowed.');
        }
    }
}
