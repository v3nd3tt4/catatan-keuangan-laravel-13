<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Nama</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Tipe</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Pengguna</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Transaksi</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Warna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $category->user->name }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $category->transactions->count() }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                            <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                                            {{ $category->color }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($categories->hasPages())
                <div class="mt-6">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
