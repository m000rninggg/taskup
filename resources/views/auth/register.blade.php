<x-guest-layout>
    <form method="POST" action="{{ route('register', absolute: false) }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name">Имя</label>
            <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ваше имя">
            @error('name')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Логин</label>
            <input id="username" class="auth-input" type="text" name="username" value="{{ old('username') }}" required placeholder="username">
            @error('username')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
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

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required placeholder="••••••••">
            @error('password_confirmation')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Зарегистрироваться</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
    </div>
</x-guest-layout>

