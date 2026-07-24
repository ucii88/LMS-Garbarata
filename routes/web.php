<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rute khusus Administrator
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users/export', [AdminUserController::class, 'export'])->name('admin.users.export');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('admin.certificates.download');
});

// Rute yang membutuhkan Login
Route::middleware('auth')->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Course interactive viewer
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/chapters/{chapter}', [CourseController::class, 'showChapter'])->name('courses.chapters.show');
    Route::post('/courses/{course}/chapters/{chapter}/modules/{module}/complete', [CourseController::class, 'completeModule'])->name('courses.modules.complete');
    Route::get('/courses/{course}/activities', [CourseController::class, 'activities'])->name('courses.activities');
    Route::get('/courses/{course}/quiz-ujian', [CourseController::class, 'quizActivities'])->name('courses.quizzes');
    Route::get('/courses/{course}/latihan', [CourseController::class, 'practiceActivities'])->name('courses.practices');

    // Fitur simulasi role (HANYA AKTIF di lingkungan LOCAL dan HANYA untuk ADMIN)
    if (app()->environment('local')) {
        Route::post('/simulasi-role', function (Illuminate\Http\Request $request) {
            abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Administrator yang dapat mensimulasikan peran.');
            $request->validate(['role' => 'required|in:admin,instruktur,peserta']);
            $user = auth()->user();
            $user->role = $request->role;
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Peran berhasil dialihkan ke ' . ucfirst($request->role));
        })->name('simulasi-role');
    }

    // Module & Content Management (Eksklusif Instruktur)
    Route::middleware('role:instruktur')->group(function () {
        // Chapter management
        Route::post('/courses/{course}/chapters', [CourseController::class, 'storeChapter'])->name('courses.chapters.store');
        Route::put('/courses/{course}/chapters/{chapter}', [CourseController::class, 'updateChapter'])->name('courses.chapters.update');
        Route::delete('/courses/{course}/chapters/{chapter}', [CourseController::class, 'destroyChapter'])->name('courses.chapters.destroy');

        // Interactive Diagram & Hotspots Management
        Route::put('/courses/{course}/chapters/{chapter}/diagram/hotspots', [CourseController::class, 'updateHotspots'])->name('courses.diagram.hotspots.update');
        Route::post('/courses/{course}/chapters/{chapter}/diagram', [CourseController::class, 'storeDiagram'])->name('courses.diagram.store');
        Route::delete('/courses/{course}/chapters/{chapter}/diagram', [CourseController::class, 'destroyDiagram'])->name('courses.diagram.destroy');
        Route::post('/courses/{course}/chapters/{chapter}/hotspots', [CourseController::class, 'storeHotspot'])->name('courses.diagram.hotspots.store');
        Route::put('/courses/{course}/chapters/{chapter}/hotspots/{hotspot}', [CourseController::class, 'updateHotspotDetails'])->name('courses.diagram.hotspots.update-details');
        Route::delete('/courses/{course}/chapters/{chapter}/hotspots/{hotspot}', [CourseController::class, 'destroyHotspot'])->name('courses.diagram.hotspots.destroy');

        Route::get('/courses/{course}/chapters/{chapter}/modules/create', [ModuleController::class, 'create'])->name('modules.create');
        Route::post('/courses/{course}/chapters/{chapter}/modules', [ModuleController::class, 'store'])->name('modules.store');
        Route::get('/courses/{course}/chapters/{chapter}/modules/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/courses/{course}/chapters/{chapter}/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/courses/{course}/chapters/{chapter}/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

        // Module Diagram & Hotspots Management
        Route::post('/courses/{course}/chapters/{chapter}/modules/{module}/diagram', [CourseController::class, 'storeModuleDiagram'])->name('courses.modules.diagram.store');
        Route::delete('/courses/{course}/chapters/{chapter}/modules/{module}/diagram', [CourseController::class, 'destroyModuleDiagram'])->name('courses.modules.diagram.destroy');
        Route::post('/courses/{course}/chapters/{chapter}/modules/{module}/hotspots', [CourseController::class, 'storeModuleHotspot'])->name('courses.modules.hotspots.store');
        Route::put('/courses/{course}/chapters/{chapter}/modules/{module}/hotspots', [CourseController::class, 'updateModuleHotspots'])->name('courses.modules.hotspots.update');
        Route::put('/courses/{course}/chapters/{chapter}/modules/{module}/hotspots/{hotspot}', [CourseController::class, 'updateModuleHotspotDetails'])->name('courses.modules.hotspots.update-details');
        Route::delete('/courses/{course}/chapters/{chapter}/modules/{module}/hotspots/{hotspot}', [CourseController::class, 'destroyModuleHotspot'])->name('courses.modules.hotspots.destroy');

        // Bank Soal — dikelola per chapter
        Route::get('/courses/{course}/chapters/{chapter}/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::post('/courses/{course}/chapters/{chapter}/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::put('/courses/{course}/chapters/{chapter}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/courses/{course}/chapters/{chapter}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

        // Manajemen Quiz
        Route::get('/courses/{course}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
        Route::get('/courses/{course}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/courses/{course}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/courses/{course}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/courses/{course}/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
        Route::patch('/courses/{course}/quizzes/{quiz}/publish', [QuizController::class, 'publish'])->name('quizzes.publish');
        Route::delete('/courses/{course}/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
        // Pilih soal dari bank untuk quiz
        Route::post('/courses/{course}/quizzes/{quiz}/questions/sync', [QuizController::class, 'syncQuestions'])->name('quizzes.questions.sync');
        // Hasil & Reset Percobaan Peserta
        Route::get('/courses/{course}/quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])->name('quizzes.attempts');
        Route::get('/courses/{course}/quizzes/{quiz}/attempts/export', [QuizController::class, 'exportAttempts'])->name('quizzes.attempts.export');
        Route::delete('/courses/{course}/quizzes/{quiz}/attempts/{attempt}', [QuizController::class, 'destroyAttempt'])->name('quizzes.attempts.destroy');
        // Penilaian Esai
        Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/grade', [QuizController::class, 'gradeEssay'])->name('quizzes.attempts.grade');
        Route::post('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/grade', [QuizController::class, 'submitGrading'])->name('quizzes.attempts.grade.submit');

        // Manajemen latihan per chapter
        Route::get('/courses/{course}/practices', [QuizController::class, 'index'])->name('practices.index');
        Route::get('/courses/{course}/practices/create', [QuizController::class, 'create'])->name('practices.create');
        Route::post('/courses/{course}/practices', [QuizController::class, 'store'])->name('practices.store');
        Route::get('/courses/{course}/practices/{quiz}/edit', [QuizController::class, 'edit'])->name('practices.edit');
        Route::put('/courses/{course}/practices/{quiz}', [QuizController::class, 'update'])->name('practices.update');
        Route::patch('/courses/{course}/practices/{quiz}/publish', [QuizController::class, 'publish'])->name('practices.publish');
        Route::delete('/courses/{course}/practices/{quiz}', [QuizController::class, 'destroy'])->name('practices.destroy');
        Route::post('/courses/{course}/practices/{quiz}/questions/sync', [QuizController::class, 'syncQuestions'])->name('practices.questions.sync');
        Route::get('/courses/{course}/practices/{quiz}/attempts', [QuizController::class, 'attempts'])->name('practices.attempts');
        Route::delete('/courses/{course}/practices/{quiz}/attempts/{attempt}', [QuizController::class, 'destroyAttempt'])->name('practices.attempts.destroy');
        // Penilaian Esai Latihan
        Route::get('/courses/{course}/practices/{quiz}/attempts/{attempt}/grade', [QuizController::class, 'gradeEssay'])->name('practices.attempts.grade');
        Route::post('/courses/{course}/practices/{quiz}/attempts/{attempt}/grade', [QuizController::class, 'submitGrading'])->name('practices.attempts.grade.submit');
    });

    // Quiz attempt & sertifikat (Peserta)
    Route::middleware('role:peserta')->group(function () {
        Route::get('/courses/{course}/quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])->name('quiz.start');
        Route::post('/courses/{course}/quizzes/{quiz}/begin', [QuizAttemptController::class, 'begin'])->name('quiz.begin');
        Route::get('/courses/{course}/quizzes/{quiz}/attempt', [QuizAttemptController::class, 'attempt'])->name('quiz.attempt');
        Route::post('/courses/{course}/quizzes/{quiz}/submit', [QuizAttemptController::class, 'submit'])->name('quiz.submit');
        Route::get('/courses/{course}/quizzes/{quiz}/result', [QuizAttemptController::class, 'result'])->name('quiz.result');
        Route::post('/courses/{course}/quizzes/{quiz}/save-answer', [QuizAttemptController::class, 'saveAnswer'])->name('quiz.save-answer');
        Route::get('/courses/{course}/practices/{quiz}/start', [QuizAttemptController::class, 'start'])->name('practice.start');
        Route::post('/courses/{course}/practices/{quiz}/begin', [QuizAttemptController::class, 'begin'])->name('practice.begin');
        Route::get('/courses/{course}/practices/{quiz}/attempt', [QuizAttemptController::class, 'attempt'])->name('practice.attempt');
        Route::post('/courses/{course}/practices/{quiz}/submit', [QuizAttemptController::class, 'submit'])->name('practice.submit');
        Route::get('/courses/{course}/practices/{quiz}/result', [QuizAttemptController::class, 'result'])->name('practice.result');
        Route::post('/courses/{course}/practices/{quiz}/save-answer', [QuizAttemptController::class, 'saveAnswer'])->name('practice.save-answer');
        Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificate.show');
    });
});

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

require __DIR__.'/auth.php';
