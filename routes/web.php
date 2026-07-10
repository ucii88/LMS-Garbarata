<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Course interactive viewer
    Route::get('/courses/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/chapters/{chapter}', [App\Http\Controllers\CourseController::class, 'showChapter'])->name('courses.chapters.show');
    Route::post('/courses/{course}/chapters/{chapter}/modules/{module}/complete', [App\Http\Controllers\CourseController::class, 'completeModule'])->name('courses.modules.complete');

    // Role simulation switcher
    Route::post('/simulasi-role', function (Illuminate\Http\Request $request) {
        $request->validate(['role' => 'required|in:admin,instruktur,peserta']);
        $user = auth()->user();
        $user->role = $request->role;
        $user->save();
        return redirect()->route('dashboard')->with('success', 'Peran berhasil dialihkan ke ' . ucfirst($request->role));
    })->name('simulasi-role');
});

require __DIR__.'/auth.php';
