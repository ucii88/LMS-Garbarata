<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\CertificateController;
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
    Route::post('/courses/{course}/chapters/{chapter}/modules/{module}/complete', [App\Http\Controllers\CourseController::class, 'completeModule'])->name('courses.modules.complete');
    Route::get('/courses/{course}/activities', [App\Http\Controllers\CourseController::class, 'activities'])->name('courses.activities');

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
        Route::delete('/courses/{course}/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
        // Pilih soal dari bank untuk kuis
        Route::post('/courses/{course}/quizzes/{quiz}/questions/sync', [QuizController::class, 'syncQuestions'])->name('quizzes.questions.sync');
        // Hasil & Reset Percobaan Peserta
        Route::get('/courses/{course}/quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])->name('quizzes.attempts');
        Route::delete('/courses/{course}/quizzes/{quiz}/attempts/{attempt}', [QuizController::class, 'destroyAttempt'])->name('quizzes.attempts.destroy');

        // Manajemen latihan per chapter (menggunakan bank soal yang sama)
        Route::get('/courses/{course}/practices', [QuizController::class, 'index'])->name('practices.index');
        Route::get('/courses/{course}/practices/create', [QuizController::class, 'create'])->name('practices.create');
        Route::post('/courses/{course}/practices', [QuizController::class, 'store'])->name('practices.store');
        Route::get('/courses/{course}/practices/{quiz}/edit', [QuizController::class, 'edit'])->name('practices.edit');
        Route::put('/courses/{course}/practices/{quiz}', [QuizController::class, 'update'])->name('practices.update');
        Route::delete('/courses/{course}/practices/{quiz}', [QuizController::class, 'destroy'])->name('practices.destroy');
        Route::post('/courses/{course}/practices/{quiz}/questions/sync', [QuizController::class, 'syncQuestions'])->name('practices.questions.sync');
        Route::get('/courses/{course}/practices/{quiz}/attempts', [QuizController::class, 'attempts'])->name('practices.attempts');
        Route::delete('/courses/{course}/practices/{quiz}/attempts/{attempt}', [QuizController::class, 'destroyAttempt'])->name('practices.attempts.destroy');
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

require __DIR__.'/auth.php';
