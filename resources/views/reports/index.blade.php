<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition">
                        Filter
                    </button>
                    <a href="{{ route('report.export-pdf', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition text-center">
                        📄 Export PDF
                    </a>
                </form>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-green-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pemasukan</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-red-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pengeluaran</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 {{ $balance >= 0 ? 'border-green-500' : 'border-red-500' }}">
                    <div class="text-sm text-gray-600 font-medium">Selisih</div>
                    <div class="mt-2 text-3xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $balance >= 0 ? '+' : '-' }} Rp {{ number_format(abs($balance), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- By Category -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian per Kategori</h3>
                    <div class="space-y-3">
                        @forelse($byCategory as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $item['category'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $item['count'] }} transaksi</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold {{ $item['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($item['total'], 0, ',', '.') }}
                                    </div>
                                    <span class="text-xs {{ $item['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item['type'] === 'income' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">Belum ada transaksi</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Persentase Pengeluaran</span>
                                <span class="font-semibold text-gray-900">{{ $totalIncome > 0 ? number_format(($totalExpense / ($totalIncome + $totalExpense)) * 100, 1) : 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalIncome > 0 ? (($totalExpense / ($totalIncome + $totalExpense)) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600">Jumlah Transaksi</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $transactions->count() }}</div>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600">Rata-rata Transaksi</div>
                            <div class="text-2xl font-bold text-gray-900">
                                Rp {{ $transactions->count() > 0 ? number_format(($totalIncome + $totalExpense) / $transactions->count(), 0, ',', '.') : 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction List -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Transaksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-3 px-6 text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-3 px-6 text-sm font-semibold text-gray-900">Kategori</th>
                                <th class="text-left py-3 px-6 text-sm font-semibold text-gray-900">Keterangan</th>
                                <th class="text-right py-3 px-6 text-sm font-semibold text-gray-900">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-6 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                                    <td class="py-3 px-6 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-sm text-gray-600">{{ $transaction->description ?? '-' }}</td>
                                    <td class="py-3 px-6 text-sm font-semibold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-6 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
