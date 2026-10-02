<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $type = match (Str::lower($search)) {
            'pemasukan', 'masuk', 'income' => 'income',
            'pengeluaran', 'keluar', 'expense' => 'expense',
            default => null,
        };

        $transactions = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->when($search !== '', function ($query) use ($search, $type) {
                $query->where(function ($query) use ($search, $type) {
                    $query->where('description', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($category) =>
                            $category->where('name', 'like', "%{$search}%")
                        )
                        ->when($type, fn ($query) =>
                            $query->orWhere('type', $type)
                        );
                });
            })
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $category = Category::find($validated['category_id']);

        if ($category->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        Transaction::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
