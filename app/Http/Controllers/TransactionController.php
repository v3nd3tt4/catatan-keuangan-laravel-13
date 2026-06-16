<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->latest('date')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
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
