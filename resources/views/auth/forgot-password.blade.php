<x-guest-layout>
    <div class="auth-subtitle" style="margin-bottom: 20px;">
        Забыли пароль? Введите ваш email, и мы отправим ссылку для сброса.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div style="color: #1de9c3; text-align: center; margin-bottom: 16px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
            @error('email')
                <small style="color: #ff6b6b;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Отправить ссылку</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        <a href="{{ route('login') }}">Вернуться ко входу</a>
    </div>
</x-guest-layout>