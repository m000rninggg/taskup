<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div style="color: #20E6C3; text-align: center; margin-bottom: 16px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
            @error('email')
                <small style="color: #C2C2D4;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Пароль</label>
            <input id="password" class="auth-input" type="password" name="password" required placeholder="••••••••">
            @error('password')
                <small style="color: #C2C2D4;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group" style="flex-direction: row; align-items: center; gap: 10px;">
            <input id="remember_me" type="checkbox" name="remember" style="width: 18px; height: 18px;">
            <label for="remember_me" style="margin: 0;">Запомнить меня</label>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: #20E6C3;">Забыли пароль?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">Войти</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
    </div>
</x-guest-layout>

