<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Имя</label>
            <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ваше имя">
            @error('name')
                <small style="color: #ff6b6b;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
            @error('email')
                <small style="color: #ff6b6b;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Пароль</label>
            <input id="password" class="auth-input" type="password" name="password" required placeholder="••••••••">
            @error('password')
                <small style="color: #ff6b6b;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required placeholder="••••••••">
            @error('password_confirmation')
                <small style="color: #ff6b6b;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Зарегистрироваться</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
    </div>
</x-guest-layout>