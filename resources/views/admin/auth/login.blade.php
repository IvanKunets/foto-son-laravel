<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход — Админ-панель Фото-сон</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body admin-body--login">
<main class="admin-login-page">
    <div class="admin-login-card">
        <header class="admin-login-header">
            <div class="admin-login-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Фото-сон" decoding="async">
            </div>
            <p class="admin-login-tagline">Административная панель</p>
        </header>
        <div class="admin-login-divider" aria-hidden="true"></div>

        <form method="post" action="{{ route('admin.login') }}" class="admin-login-form">
            @csrf
            <div class="admin-login-field">
                <label for="email">Логин</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    class="@error('email') is-invalid @enderror"
                    @if ($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                    placeholder="Введите E-mail"
                >
                @error('email')
                    <p id="email-error" class="admin-login-field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="admin-login-field">
                <label for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="@error('password') is-invalid @enderror"
                    @if ($errors->has('password')) aria-invalid="true" aria-describedby="password-error" @endif
                    placeholder="Введите пароль"
                >
                @error('password')
                    <p id="password-error" class="admin-login-field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="admin-login-remember checkbox-field">
                <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                <label for="remember">Запомнить меня</label>
            </div>
            <button type="submit" class="admin-login-submit">Войти</button>
        </form>

        <p class="admin-login-back">
            <a href="{{ url('/') }}">На главную сайта</a>
        </p>
        <footer class="admin-login-footer">
            <p class="admin-login-caption">© {{ date('Y') }} Фото-сон</p>
        </footer>
    </div>
</main>
</body>
</html>
