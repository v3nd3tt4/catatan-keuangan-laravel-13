<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

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

    public function userTransactions(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

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
}
