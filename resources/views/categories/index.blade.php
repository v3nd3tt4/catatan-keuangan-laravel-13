<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori</h2>
            <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Kategori Pemasukan -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="inline-block w-4 h-4 bg-green-500 rounded-full mr-2"></span>
                    Kategori Pemasukan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($income as $category)
                        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></div>
                                    <h4 class="font-semibold text-gray-900">{{ $category->name }}</h4>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 mb-3">
                                {{ $category->transactions()->count() }} transaksi
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', $category) }}" class="flex-1 px-3 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-900 border border-indigo-300 rounded hover:bg-indigo-50 transition text-center">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-red-600 hover:text-red-900 border border-red-300 rounded hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 col-span-full">
                            Belum ada kategori pemasukan
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kategori Pengeluaran -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="inline-block w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                    Kategori Pengeluaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($expense as $category)
                        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></div>
                                    <h4 class="font-semibold text-gray-900">{{ $category->name }}</h4>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 mb-3">
                                {{ $category->transactions()->count() }} transaksi
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', $category) }}" class="flex-1 px-3 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-900 border border-indigo-300 rounded hover:bg-indigo-50 transition text-center">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-red-600 hover:text-red-900 border border-red-300 rounded hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 col-span-full">
                            Belum ada kategori pengeluaran
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
