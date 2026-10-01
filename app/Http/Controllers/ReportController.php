<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->startOfMonth();
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now()->endOfMonth();

        $transactions = Transaction::where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->with('category')
            ->latest('date')
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $byCategory = $transactions->groupBy('category_id')->map(function ($group) {
            $first = $group->first();
            return [
                'category' => $first->category->name,
                'type' => $first->type,
                'total' => $group->sum('amount'),
                'count' => $group->count(),
            ];
        });

        return view('reports.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'byCategory',
            'startDate',
            'endDate'
        ));
    }

    public function byCategory()
    {
        $categories = Category::where('user_id', auth()->id())->get();

        $report = $categories->map(function ($category) {
            $transactions = $category->transactions()
                ->where('user_id', auth()->id())
                ->get();

            return [
                'category' => $category,
                'total' => $transactions->sum('amount'),
                'count' => $transactions->count(),
                'transactions' => $transactions,
            ];
        });

        return view('reports.by-category', compact('report'));
    }

    public function exportPdf()
    {
        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->startOfMonth();
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now()->endOfMonth();

        $transactions = Transaction::where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->with('category')
            ->latest('date')
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $byCategory = $transactions->groupBy('category_id')->map(function ($group) {
            $first = $group->first();
            return [
                'category' => $first->category->name,
                'type' => $first->type,
                'total' => $group->sum('amount'),
                'count' => $group->count(),
            ];
        });

        $user = auth()->user();

        $pdf = PDF::loadView('reports.pdf', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'byCategory',
            'startDate',
            'endDate',
            'user'
        ));

        return $pdf->download('Laporan_Transaksi_' . now()->format('d-m-Y') . '.pdf');
    }
}
