<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Transaksi</h2>
            <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                + Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200">
                    <p class="text-sm text-gray-500">
                        {{ $transactions->total() }} transaksi
                        @if ($search !== '')
                            <span class="text-gray-400">untuk "{{ $search }}"</span>
                        @endif
                    </p>

                    <form
                        method="GET"
                        action="{{ route('transactions.index') }}"
                        class="flex items-center gap-2 w-full sm:w-auto"
                        x-data="{ keyword: @js($search), applied: @js($search) }"
                        @input.debounce.500ms="if (keyword !== applied) $el.submit()"
                    >
                        <div class="relative flex-1 sm:flex-none sm:w-72">
                            <input
                                type="search"
                                name="search"
                                x-model="keyword"
                                value="{{ $search }}"
                                placeholder="Cari keterangan, kategori, atau tipe..."
                                class="w-full ps-9 pe-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                            Cari
                        </button>
                        @if ($search !== '')
                            <a href="{{ route('transactions.index') }}" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Kategori</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Tipe</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Keterangan</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-900">Jumlah</th>
                                <th class="text-center py-4 px-6 text-sm font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->description ?? '-' }}</td>
                                    <td class="py-4 px-6 text-sm font-semibold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="inline-block px-3 py-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                        @if ($search !== '')
                                            Tidak ada transaksi yang cocok dengan pencarian "{{ $search }}"
                                        @else
                                            Belum ada transaksi
                                        @endif
                                    </td>
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
        </div>
    </div>
</x-app-layout>
