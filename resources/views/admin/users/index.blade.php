<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Nama</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Email</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Bergabung</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ route('admin.user-transactions', $user) }}" class="inline-block px-3 py-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                            Lihat Transaksi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-6 text-center text-gray-500">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
