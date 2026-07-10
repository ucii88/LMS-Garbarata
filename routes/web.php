<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-chapter-4', function () {
    $course = \App\Models\Course::findOrFail(1);
    $chapter = \App\Models\Chapter::where('course_id', 1)->where('order', 4)->first();
    $chapters = $course->chapters()->orderBy('order')->get();
    $diagram = $chapter->diagram;
    $modules = $chapter->modules;
    $user = \App\Models\User::where('role', 'instruktur')->first();
    if ($user) {
        auth()->login($user);
    }
    return view('courses.study', [
        'course' => $course,
        'chapter' => $chapter,
        'chapters' => $chapters,
        'diagram' => $diagram,
        'modules' => $modules,
    ]);
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

    // Role simulation switcher
    Route::post('/simulasi-role', function (Illuminate\Http\Request $request) {
        $request->validate(['role' => 'required|in:admin,instruktur,peserta']);
        $user = auth()->user();
        $user->role = $request->role;
        $user->save();
        return redirect()->route('dashboard')->with('success', 'Peran berhasil dialihkan ke ' . ucfirst($request->role));
    })->name('simulasi-role');

    // Module management (exclusive to Instruktur)
    Route::middleware('role:instruktur')->group(function () {
        Route::get('/courses/{course}/chapters/{chapter}/modules/create', [App\Http\Controllers\ModuleController::class, 'create'])->name('modules.create');
        Route::post('/courses/{course}/chapters/{chapter}/modules', [App\Http\Controllers\ModuleController::class, 'store'])->name('modules.store');
        Route::get('/courses/{course}/chapters/{chapter}/modules/{module}/edit', [App\Http\Controllers\ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/courses/{course}/chapters/{chapter}/modules/{module}', [App\Http\Controllers\ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/courses/{course}/chapters/{chapter}/modules/{module}', [App\Http\Controllers\ModuleController::class, 'destroy'])->name('modules.destroy');
    });
});

require __DIR__.'/auth.php';
