<x-guest-layout>
    <div class="auth-subtitle auth-subtitle-compact">
        Забыли пароль? Введите ваш email, и мы отправим ссылку для сброса.
    </div>

    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email', absolute: false) }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
            @error('email')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Отправить ссылку</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        <a href="{{ route('login') }}">Вернуться ко входу</a>
    </div>
</x-guest-layout>

