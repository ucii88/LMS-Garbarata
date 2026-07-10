<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'email' => Str::lower($request->input('email', '')),
        ]);

        $roleLabels = [
            'admin' => 'admin',
            'instruktur' => 'instruktur',
            'peserta' => 'peserta',
        ];
        $roleLabel = $roleLabels[$request->input('role')] ?? $request->input('role', 'user');
        $email = $request->input('email', 'akun baru');

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,instruktur,peserta'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard')
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->with('error', "Gagal menambahkan akun {$email}, sebagai {$roleLabel}.");
        }

        $validated = $validator->validated();
        $name = ($validated['name'] ?? '') ?: Str::of($validated['email'])
            ->before('@')
            ->replace(['.', '_', '-'], ' ')
            ->title()
            ->toString();

        User::create([
            'name' => $name,
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', "Berhasil menambahkan akun {$validated['email']}, sebagai {$roleLabels[$validated['role']]}.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User berhasil dihapus.');
    }
}
