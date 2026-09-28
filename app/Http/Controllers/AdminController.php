<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalTransactions = Transaction::count();
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        $recentTransactions = Transaction::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'totalIncome',
            'totalExpense',
            'recentTransactions'
        ));
    }

    public function users()
    {
        $users = User::where('role', 'user')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Verifikasi email user secara manual oleh admin.
     */
    public function verifyUser(User $user): RedirectResponse
    {
        $this->ensureIsManagedUser($user);

        if ($user->hasVerifiedEmail()) {
            return back()->with('warning', "Email {$user->email} sudah terverifikasi sebelumnya.");
        }

        $user->markEmailAsVerified();

        event(new Verified($user));

        return back()->with('success', "Verifikasi email {$user->email} berhasil dilakukan.");
    }

    /**
     * Batalkan verifikasi email user.
     */
    public function unverifyUser(User $user): RedirectResponse
    {
        $this->ensureIsManagedUser($user);

        if (! $user->hasVerifiedEmail()) {
            return back()->with('warning', "Email {$user->email} belum terverifikasi.");
        }

        $user->forceFill(['email_verified_at' => null])->save();

        return back()->with('success', "Verifikasi email {$user->email} berhasil dibatalkan.");
    }

    /**
     * Bantu user mengubah passwordnya.
     */
    public function updateUserPassword(Request $request, User $user): RedirectResponse
    {
        $this->ensureIsManagedUser($user);

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [], ['password' => 'password baru']);

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        return back()->with('success', "Password untuk {$user->name} berhasil diubah.");
    }

    public function userTransactions(User $user)
    {
        $this->ensureIsManagedUser($user);

        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->startOfMonth();
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now()->endOfMonth();

        $transactions = $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->with('category')
            ->latest('date')
            ->paginate(15);

        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        return view('admin.user-transactions', compact('user', 'transactions', 'totalIncome', 'totalExpense', 'startDate', 'endDate'));
    }

    public function allTransactions()
    {
        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->startOfMonth();
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now()->endOfMonth();

        $transactions = Transaction::with(['user', 'category'])
            ->whereBetween('date', [$startDate, $endDate])
            ->latest('date')
            ->paginate(20);

        $totalIncome = Transaction::where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = Transaction::where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        return view('admin.transactions', compact('transactions', 'totalIncome', 'totalExpense', 'startDate', 'endDate'));
    }

    public function categories()
    {
        $categories = Category::with(['user', 'transactions'])
            ->paginate(15);

        return view('admin.categories', compact('categories'));
    }

    /**
     * Pastikan target aksi admin adalah akun user biasa, bukan akun admin.
     */
    private function ensureIsManagedUser(User $user): void
    {
        if ($user->isAdmin()) {
            abort(403, 'Aksi ini hanya dapat dilakukan pada akun user.');
        }
    }
}
