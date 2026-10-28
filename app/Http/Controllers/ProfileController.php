<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\SignatureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected SignatureService $signatureService;

    public function __construct(SignatureService $signatureService)
    {
        $this->signatureService = $signatureService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'signature' => $request->user()->isInstruktur()
                ? $this->signatureService->getCurrentSignature($request->user(), 'instructor')
                : null,
        ]);
    }

    /**
     * Display instructor profile with signature
     * GET /profile
     */
    public function show()
    {
        $user = auth()->user();
        $signature = $this->signatureService->getCurrentSignature($user, 'instructor');

        // Get courses where this instructor is assigned
        $courses = [];
        if ($user->role === 'instruktur') {
            $courses = \App\Models\CertificateConfiguration::where('instructor_id', $user->id)
                ->with('course')
                ->get()
                ->pluck('course');
        }

        return view('profile.show', compact('user', 'signature', 'courses'));
    }

    /**
     * Save signature from canvas
     * POST /profile/signature
     */
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string',
        ]);

        try {
            $signature = $this->signatureService->saveFromCanvas(
                auth()->user(),
                $request->signature_data,
                'instructor'
            );

            return response()->json([
                'success' => true,
                'message' => __('Tanda tangan berhasil disimpan!'),
                'signature_url' => $signature->signature_url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Tampilkan halaman tanda tangan digital instruktur
     * GET /profile/signature
     */
    public function showSignature()
    {
        $user = auth()->user();
        $signature = $this->signatureService->getCurrentSignature($user, 'instructor');
        $courses = \App\Models\CertificateConfiguration::where('instructor_id', $user->id)
            ->with('course')
            ->get()
            ->pluck('course')
            ->filter();

        return view('profile.signature', compact('user', 'signature', 'courses'));
    }

    /**
     * Upload signature from file
     * POST /profile/signature/upload
     */
    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature_file' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        try {
            $signature = $this->signatureService->saveFromFile(
                auth()->user(),
                $request->file('signature_file'),
                'instructor'
            );

            return redirect()->back()->with('success', __('Tanda tangan berhasil diunggah.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            if ($request->user()->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($request->user()->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
