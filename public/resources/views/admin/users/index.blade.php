<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna</h2>
    </x-slot>

    @php
        $passwordErrorUserId = $errors->has('password') ? (int) old('_user_id') : null;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any() && $passwordErrorUserId === null)
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc space-y-1 ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Nama</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Email</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Verifikasi</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-900">Bergabung</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        @if ($user->hasVerifiedEmail())
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Belum Terverifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-6">
                                        <div
                                            class="flex justify-end"
                                            x-data="{ open: false, top: 0, left: 0 }"
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            @scroll.window="open = false"
                                        >
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
                                                @click="
                                                    const rect = $el.getBoundingClientRect();
                                                    open = ! open;
                                                    top = window.innerHeight - rect.bottom < 140 ? rect.top - 140 : rect.bottom + 4;
                                                    left = Math.max(8, rect.right - 224);
                                                "
                                            >
                                                Aksi
                                                <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <template x-if="open">
                                                <div
                                                    class="fixed z-50 w-56 py-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                                    :style="`top: ${top}px; left: ${left}px`"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                >
                                                    <a
                                                        href="{{ route('admin.user-transactions', $user) }}"
                                                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                                    >
                                                        Lihat Transaksi
                                                    </a>

                                                    @if ($user->hasVerifiedEmail())
                                                        <button
                                                            type="button"
                                                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-amber-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                                            @click="open = false; $dispatch('open-modal', 'unverify-user-{{ $user->id }}')"
                                                        >
                                                            Batalkan Verifikasi
                                                        </button>
                                                    @else
                                                        <button
                                                            type="button"
                                                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-green-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                                            @click="open = false; $dispatch('open-modal', 'verify-user-{{ $user->id }}')"
                                                        >
                                                            Verifikasi Email
                                                        </button>
                                                    @endif

                                                    <button
                                                        type="button"
                                                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                                        @click="open = false; $dispatch('open-modal', 'password-user-{{ $user->id }}')"
                                                    >
                                                        Ubah Password
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach ($users as $user)
                <x-modal name="verify-user-{{ $user->id }}" maxWidth="md">
                    <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="p-6">
                        @csrf
                        @method('PATCH')

                        <h2 class="text-lg font-medium text-gray-900">Verifikasi Email</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Tandai email <span class="font-medium text-gray-900">{{ $user->email }}</span>
                            sebagai terverifikasi? Setelah itu user dapat langsung masuk ke aplikasi
                            tanpa harus membuka link verifikasi dari email.
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                Ya, Verifikasi
                            </button>
                        </div>
                    </form>
                </x-modal>

                <x-modal name="unverify-user-{{ $user->id }}" maxWidth="md">
                    <form method="POST" action="{{ route('admin.users.unverify', $user) }}" class="p-6">
                        @csrf
                        @method('DELETE')

                        <h2 class="text-lg font-medium text-gray-900">Batalkan Verifikasi</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Email <span class="font-medium text-gray-900">{{ $user->email }}</span> akan
                            ditandai belum terverifikasi lagi dan user harus membuka link verifikasi
                            baru melalui email.
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition">
                                Ya, Batalkan
                            </button>
                        </div>
                    </form>
                </x-modal>

                <x-modal name="password-user-{{ $user->id }}" :show="$passwordErrorUserId === $user->id" maxWidth="md" focusable>
                    <form method="POST" action="{{ route('admin.users.password', $user) }}" class="p-6">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="_user_id" value="{{ $user->id }}">

                        <h2 class="text-lg font-medium text-gray-900">Ubah Password</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Password baru untuk <span class="font-medium text-gray-900">{{ $user->name }}</span>
                            ({{ $user->email }}).
                        </p>
                        <p class="mt-2 text-sm text-amber-700">
                            Sampaikan password ini ke user secara pribadi. User akan otomatis
                            keluar dari perangkat lain yang sedang login.
                        </p>

                        <div class="mt-4">
                            <x-input-label for="password_user_{{ $user->id }}" value="Password Baru" />
                            <x-text-input
                                id="password_user_{{ $user->id }}"
                                name="password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password_confirmation_user_{{ $user->id }}" value="Konfirmasi Password Baru" />
                            <x-text-input
                                id="password_confirmation_user_{{ $user->id }}"
                                name="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                Simpan Password
                            </button>
                        </div>
                    </form>
                </x-modal>
            @endforeach

            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
