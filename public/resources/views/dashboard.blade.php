<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Month Income -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-green-500">
                    <div class="text-sm text-gray-600 font-medium">Pemasukan (Bulan Ini)</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($monthIncome, 0, ',', '.') }}</div>
                </div>

                <!-- Month Expense -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-red-500">
                    <div class="text-sm text-gray-600 font-medium">Pengeluaran (Bulan Ini)</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($monthExpense, 0, ',', '.') }}</div>
                </div>

                <!-- Month Balance -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 {{ $monthBalance >= 0 ? 'border-blue-500' : 'border-orange-500' }}">
                    <div class="text-sm text-gray-600 font-medium">Saldo (Bulan Ini)</div>
                    <div class="mt-2 text-2xl font-bold {{ $monthBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $monthBalance >= 0 ? '' : '-' }} &nbsp;
                        Rp {{ number_format(abs($monthBalance), 0, ',', '.') }}
                    </div>
                </div>

                <!-- Total Balance -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-indigo-500">
                    <div class="text-sm text-gray-600 font-medium">Total Saldo</div>
                    <div class="mt-2 text-2xl font-bold {{ $totalBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $totalBalance >= 0 ? '' : '-' }} &nbsp;
                        Rp {{ number_format(abs($totalBalance), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Top Categories -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Kategori Terbanyak</h3>
                        <a href="{{ route('report.by-category') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua →</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($topCategories as $category)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $category['color'] }}"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $category['name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $category['count'] }} transaksi</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($category['total'], 0, ',', '.') }}</div>
                                    <div class="mt-1 flex items-center justify-end space-x-2">
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded {{ $category['type'] === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $category['type'] === 'income' ? 'Masuk' : 'Keluar' }}
                                        </span>
                                        <a href="{{ route('categories.edit', $category['id']) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-medium">Edit</a>
                                        <form method="POST" action="{{ route('categories.destroy', $category['id']) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-medium bg-transparent border-0 p-0">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">Belum ada kategori</div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('transactions.create') }}" class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-lg text-center font-medium hover:bg-indigo-700 transition">
                            + Tambah Transaksi
                        </a>
                        <a href="{{ route('categories.create') }}" class="block w-full px-4 py-3 border-2 border-indigo-600 text-indigo-600 rounded-lg text-center font-medium hover:bg-indigo-50 transition">
                            + Tambah Kategori
                        </a>
                        <a href="{{ route('categories.index') }}" class="block w-full px-4 py-3 border-2 border-gray-200 text-gray-700 rounded-lg text-center font-medium hover:bg-gray-50 transition">
                            ⚙️ Kelola Kategori
                        </a>
                        <a href="{{ route('report.index') }}" class="block w-full px-4 py-3 border-2 border-gray-200 text-gray-700 rounded-lg text-center font-medium hover:bg-gray-50 transition">
                            📊 Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Kategori</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Keterangan</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-900">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $transaction->description ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
