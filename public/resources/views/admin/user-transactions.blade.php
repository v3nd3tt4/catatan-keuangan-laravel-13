<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter Periode -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : now()->startOfMonth()->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : now()->endOfMonth()->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-green-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pemasukan</div>
                    <div class="mt-2 text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-red-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pengeluaran</div>
                    <div class="mt-2 text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 {{ ($totalIncome - $totalExpense) >= 0 ? 'border-green-500' : 'border-red-500' }}">
                    <div class="text-sm text-gray-600 font-medium">Saldo</div>
                    <div class="mt-2 text-2xl font-bold {{ ($totalIncome - $totalExpense) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format(abs($totalIncome - $totalExpense), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Kategori</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Tipe</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Keterangan</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-900">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type === 'income' ? 'Masuk' : 'Keluar' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->description ?? '-' }}</td>
                                    <td class="py-4 px-6 text-sm font-semibold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transactions->hasPages())
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('admin.users') }}" class="px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                    Kembali ke Daftar Pengguna
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
