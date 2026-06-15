<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan per Kategori</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @forelse($report as $item)
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4" style="border-color: {{ $item['category']->color }}">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-sm text-gray-600 font-medium">{{ $item['category']->name }}</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">Rp {{ number_format($item['total'], 0, ',', '.') }}</div>
                            </div>
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $item['category']->color }}20">
                                <span class="text-lg" style="color: {{ $item['category']->color }}">
                                    {{ $item['category']->type === 'income' ? '📈' : '📉' }}
                                </span>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 mb-4">
                            {{ $item['count'] }} transaksi • {{ $item['category']->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </div>

                        @if($item['transactions']->count() > 0)
                            <div class="space-y-2">
                                @foreach($item['transactions']->take(3) as $transaction)
                                    <div class="flex items-center justify-between text-xs p-2 bg-gray-50 rounded">
                                        <span class="text-gray-600">{{ $transaction->date->format('d M') }}</span>
                                        <span class="font-medium text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                                @if($item['count'] > 3)
                                    <div class="text-center text-xs text-indigo-600 font-medium pt-2">
                                        +{{ $item['count'] - 3 }} transaksi lainnya
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p class="text-lg font-medium">Belum ada kategori</p>
                        <p class="text-sm mt-1">Buat kategori terlebih dahulu untuk melacak transaksi Anda</p>
                        <a href="{{ route('categories.create') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                            + Tambah Kategori
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
