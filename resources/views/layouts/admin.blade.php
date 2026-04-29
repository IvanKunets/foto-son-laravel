<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админ-панель — Фото-сон')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
<div class="admin-layout">
    <aside class="admin-sidebar" aria-label="Разделы админки">
        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand__link" aria-label="Админ-панель Фото-сон">
                <img src="{{ asset('images/logo.png') }}" alt="Фото-сон" class="admin-brand__logo">
            </a>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Дашборд</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">Заявки</a>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">Услуги</a>
            <a href="{{ route('admin.gallery') }}" class="{{ request()->routeIs('admin.gallery*') ? 'is-active' : '' }}">Галерея</a>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'is-active' : '' }}">Отзывы</a>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="{{ url('/') }}" class="btn-ghost">Вернуться на сайт</a>
            {{-- Выход через POST и CSRF: исключаем срабатывание выхода по GET-ссылке или внешнему ресурсу --}}
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm btn-block">Выйти</button>
            </form>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__inner">
                <h1>@yield('page_title')</h1>
                <div class="admin-user" aria-label="Текущий пользователь">
                    <img src="{{ asset('images/admin/admin-user-avatar.svg') }}" alt="" class="admin-user__avatar" aria-hidden="true">
                    <span class="admin-user__name">Администратор</span>
                </div>
            </div>
        </header>
        <div class="admin-content">
            <div class="admin-content__inner">
                @if (session('success'))
                    <div class="admin-alert admin-alert--success" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="admin-alert admin-alert--error" role="alert">
                        <strong>Проверьте форму:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</div>
</body>
</html>
