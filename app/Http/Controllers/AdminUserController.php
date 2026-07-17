<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    private function formatScore($score): string
    {
        return rtrim(rtrim(number_format((float) $score, 2, '.', ''), '0'), '.');
    }

    private function formatQuizScores(int $userId): string
    {
        $attemptGroups = QuizAttempt::query()
            ->where('user_id', $userId)
            ->whereHas('quiz', fn ($query) => $query->whereNotNull('chapter_id')->where('activity_type', 'quiz'))
            ->with(['quiz.chapter'])
            ->get()
            ->groupBy('quiz_id');

        if ($attemptGroups->isEmpty()) {
            return '-';
        }

        return $attemptGroups
            ->map(function ($attempts) {
                $bestAttempt = $attempts->sortByDesc('score')->first();
                $quiz = $bestAttempt->quiz;
                $label = $quiz?->title ?: ('Quiz ' . ($quiz?->chapter?->order ?? $quiz?->order ?? $quiz?->id));

                return $label . ': ' . $this->formatScore($bestAttempt->score);
            })
            ->implode(', ');
    }

    private function formatExamScore(int $userId): string
    {
        $bestAttempt = QuizAttempt::query()
            ->where('user_id', $userId)
            ->whereHas('quiz', fn ($query) => $query->whereNull('chapter_id')->where('activity_type', 'quiz'))
            ->orderByDesc('score')
            ->first();

        return $bestAttempt ? $this->formatScore($bestAttempt->score) : '-';
    }

    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $roleFilter = $request->input('role', '');

        $query = User::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && in_array($roleFilter, ['admin', 'instruktur', 'peserta'])) {
            $query->where('role', $roleFilter);
        }

        $users = $query->paginate(15)->withQueryString();

        $counts = [
            'total'      => User::count(),
            'admin'      => User::where('role', 'admin')->count(),
            'instruktur' => User::where('role', 'instruktur')->count(),
            'peserta'    => User::where('role', 'peserta')->count(),
        ];

        return view('admin.users.index', compact('users', 'counts', 'search', 'roleFilter'));
    }

    /**
     * Export users to CSV/Excel format.
     */
    public function export(Request $request)
    {
        $search = $request->input('search', '');
        $roleFilter = $request->input('role', '');

        $query = User::query()->latest()->with(['moduleProgress', 'moduleProgress.module']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && in_array($roleFilter, ['admin', 'instruktur', 'peserta'])) {
            $query->where('role', $roleFilter);
        }

        $users = $query->get();

        $filename = 'Data_Pengguna_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            
            // Output BOM to make sure Excel reads UTF-8 properly
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['No', 'Nama Lengkap', 'Email', 'Peran', 'Tanggal Daftar', 'Nilai Quiz', 'Nilai Ujian', 'Link Sertifikat'], ';');

            $no = 1;
            foreach ($users as $user) {
                $quizScore = $this->formatQuizScores($user->id);
                $examScore = $this->formatExamScore($user->id);

                $certificates = \App\Models\Certificate::where('user_id', $user->id)->get();
                $certLinks = [];
                foreach ($certificates as $cert) {
                    $certLinks[] = route('admin.certificates.download', $cert->id);
                }
                $certLinksStr = implode(', ', $certLinks) ?: '-';

                fputcsv($file, [
                    $no++,
                    $user->name,
                    $user->email,
                    ucfirst($user->role),
                    $user->created_at->format('d M Y H:i:s'),
                    $quizScore,
                    $examScore,
                    $certLinksStr
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the detailed information of the specified user.
     */
    public function show(User $user)
    {
        $quizAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->with('quiz.course', 'quiz.chapter')
            ->latest('submitted_at')
            ->get();

        $certificates = \App\Models\Certificate::where('user_id', $user->id)
            ->with('course')
            ->latest('issued_at')
            ->get();

        return view('admin.users.show', compact('user', 'quizAttempts', 'certificates'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name'     => ['nullable', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'string', 'in:admin,instruktur,peserta'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        $validator = Validator::make($request->merge([
            'email' => Str::lower($request->input('email', '')),
        ])->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.users.edit', $user->id)
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $validated = $validator->validated();

        $name = ($validated['name'] ?? '') ?: Str::of($validated['email'])
            ->before('@')
            ->replace(['.', '_', '-'], ' ')
            ->title()
            ->toString();

        $user->name  = $name;
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Data pengguna {$user->email} berhasil diperbarui.");
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'email' => Str::lower($request->input('email', '')),
        ]);

        $roleLabels = [
            'admin'      => 'admin',
            'instruktur' => 'instruktur',
            'peserta'    => 'peserta',
        ];
        $roleLabel = $roleLabels[$request->input('role')] ?? $request->input('role', 'user');
        $email = $request->input('email', 'akun baru');

        $validator = Validator::make($request->all(), [
            'name'     => ['nullable', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role'     => ['required', 'string', 'in:admin,instruktur,peserta'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->with('error', "Gagal menambahkan akun {$email}, sebagai {$roleLabel}.")
                ->with('showModal', true);
        }

        $validated = $validator->validated();
        $name = ($validated['name'] ?? '') ?: Str::of($validated['email'])
            ->before('@')
            ->replace(['.', '_', '-'], ' ')
            ->title()
            ->toString();

        $newUser = User::create([
            'name'     => $name,
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => $validated['role'],
        ]);

        Notification::notifyUserCreated($newUser);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Berhasil menambahkan akun {$validated['email']}, sebagai {$roleLabels[$validated['role']]}.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
