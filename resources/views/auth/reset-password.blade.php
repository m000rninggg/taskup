<x-guest-layout>
    <div class="auth-subtitle auth-subtitle-compact">
        Введите новый пароль
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="your@email.com">
            @error('email')
                <small class="auth-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Новый пароль</label>
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

        <button type="submit" class="auth-btn">Сбросить пароль</button>
    </form>

    <div class="auth-divider">или</div>

    <div class="auth-links">
        <a href="{{ route('login') }}">Вернуться ко входу</a>
    </div>
</x-guest-layout>

