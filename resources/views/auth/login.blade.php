<x-guest-layout>
    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login', absolute: false) }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
            @error('email')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input id="password" class="auth-input" type="password" name="password" required placeholder="••••••••">
            @error('password')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="auth-remember">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Запомнить меня</label>
        </div>

        <div class="auth-forgot">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Забыли пароль?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">Войти</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
    </div>
</x-guest-layout>

