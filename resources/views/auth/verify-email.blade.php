<x-guest-layout>
    <div class="breeze-help">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="breeze-status">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="breeze-actions breeze-actions-between">
        <form method="POST" action="{{ route('verification.send', absolute: false) }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout', absolute: false) }}">
            @csrf

            <button type="submit" class="breeze-link-button">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>

