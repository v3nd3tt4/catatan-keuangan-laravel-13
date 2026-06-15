<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Ringkasan bulan ini
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $monthTransactions = Transaction::where('user_id', auth()->id())
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $monthIncome = $monthTransactions->where('type', 'income')->sum('amount');
        $monthExpense = $monthTransactions->where('type', 'expense')->sum('amount');
        $monthBalance = $monthIncome - $monthExpense;

        // Total keseluruhan
        $allTransactions = Transaction::where('user_id', auth()->id())->get();
        $totalIncome = $allTransactions->where('type', 'income')->sum('amount');
        $totalExpense = $allTransactions->where('type', 'expense')->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;

        // Transaksi terbaru
        $recentTransactions = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->latest('date')
            ->take(5)
            ->get();

        // Kategori dengan transaksi terbanyak
        $topCategories = Category::where('user_id', auth()->id())
            ->with('transactions')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'type' => $category->type,
                    'color' => $category->color,
                    'total' => $category->transactions->sum('amount'),
                    'count' => $category->transactions->count(),
                ];
            })
            ->sortByDesc('total')
            ->take(6);

        return view('dashboard', compact(
            'monthIncome',
            'monthExpense',
            'monthBalance',
            'totalIncome',
            'totalExpense',
            'totalBalance',
            'recentTransactions',
            'topCategories'
        ));
    }
}
