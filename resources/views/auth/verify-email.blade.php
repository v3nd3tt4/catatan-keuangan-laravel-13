<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, silahkan Anda memverifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email tersebut, dengan senang hati kami akan mengirimkan yang baru.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}" x-data="{ time: 180 }" x-init="setInterval(() => { if(time > 0) time-- }, 1000)">
            @csrf

            <div>
                <x-primary-button x-bind:disabled="time > 0" x-bind:class="{'opacity-50 cursor-not-allowed': time > 0}">
                    <span x-show="time === 0" style="display: none;">{{ __('Resend Verification Email') }}</span>
                    <span x-show="time > 0">{{ __('Resend Verification Email') }} (<span x-text="time"></span>s)</span>
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
