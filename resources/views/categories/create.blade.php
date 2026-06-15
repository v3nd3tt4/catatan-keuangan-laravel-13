<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kategori</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror" placeholder="Contoh: Gaji, Makan, Bensin...">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Tipe Kategori</label>
                        <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('type') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warna -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Warna</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="color" value="{{ old('color', '#6366f1') }}" class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                            <div class="flex-1">
                                <input type="text" value="{{ old('color', '#6366f1') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="#6366f1" readonly>
                            </div>
                        </div>
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition">
                            Simpan Kategori
                        </button>
                        <a href="{{ route('categories.index') }}" class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
