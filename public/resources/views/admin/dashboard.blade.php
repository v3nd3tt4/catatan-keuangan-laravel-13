<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-blue-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pengguna</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalUsers }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-purple-500">
                    <div class="text-sm text-gray-600 font-medium">Total Transaksi</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalTransactions }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-green-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pemasukan</div>
                    <div class="mt-2 text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-red-500">
                    <div class="text-sm text-gray-600 font-medium">Total Pengeluaran</div>
                    <div class="mt-2 text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Manage Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('admin.users') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Kelola Pengguna</h3>
                            <p class="text-sm text-gray-600 mt-1">Lihat dan kelola semua pengguna aplikasi</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354L9 6.172m3-1.818l3 1.818M9 20h6a2 2 0 002-2v-1a6 6 0 00-12 0v1a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('admin.transactions') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Semua Transaksi</h3>
                            <p class="text-sm text-gray-600 mt-1">Lihat dan analisis semua transaksi pengguna</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('admin.categories') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Kategori</h3>
                            <p class="text-sm text-gray-600 mt-1">Lihat semua kategori dari semua pengguna</p>
                        </div>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.5a2 2 0 00-1 3.75A2 2 0 0015 15h-2.5a2 2 0 00-1-3.75"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Pengguna</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Kategori</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Tipe</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-900">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $transaction->user->name }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type === 'income' ? 'Masuk' : 'Keluar' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm font-semibold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-4 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
