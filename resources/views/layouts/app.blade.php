<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- SEO и Open Graph задаются здесь один раз: страницы переопределяют только секции, без дублирования мета-тегов --}}
    @php
        $defaultMetaTitle = 'Фото-сон — фотосалон в Ростове-на-Дону';
        $defaultMetaDescription = 'Фото-сон в Ростове-на-Дону: студийные, семейные и портретные фотосессии, профессиональная обработка и индивидуальный подход к каждому клиенту.';
        $metaTitle = trim($__env->yieldContent('meta_title')) ?: trim($__env->yieldContent('title', $defaultMetaTitle));
        $metaDescription = trim($__env->yieldContent('meta_description')) ?: $defaultMetaDescription;
        $metaOgTitle = trim($__env->yieldContent('meta_og_title')) ?: $metaTitle;
        $metaOgDescription = trim($__env->yieldContent('meta_og_description')) ?: $metaDescription;
        $metaOgType = trim($__env->yieldContent('meta_og_type')) ?: 'website';
        $metaOgUrl = trim($__env->yieldContent('meta_og_url')) ?: url()->current();
        $metaOgImage = trim($__env->yieldContent('meta_og_image')) ?: asset('images/logo.png');
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:title" content="{{ $metaOgTitle }}">
    <meta property="og:description" content="{{ $metaOgDescription }}">
    <meta property="og:type" content="{{ $metaOgType }}">
    <meta property="og:url" content="{{ $metaOgUrl }}">
    <meta property="og:image" content="{{ $metaOgImage }}">
    @stack('meta')
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    <header class="site-header" data-site-header>
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo header-brand" aria-label="Фото-сон">
                <img src="{{ asset('images/logo.png') }}" alt="Логотип фотосалона Фото-сон">
            </a>
            <button class="nav-toggle" type="button" data-nav-toggle aria-label="Открыть меню" aria-controls="site-main-nav">
                <span class="nav-toggle__bars" aria-hidden="true">
                    <span class="nav-toggle__line"></span>
                    <span class="nav-toggle__line"></span>
                    <span class="nav-toggle__line"></span>
                </span>
            </button>
            <div class="header-nav-wrap">
                <nav class="main-nav" id="site-main-nav" data-main-nav>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
                    <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}">Услуги</a>
                    <a href="{{ route('gallery.index') }}" class="nav-link {{ request()->routeIs('gallery.index') ? 'active' : '' }}">Галерея</a>
                    <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->routeIs('reviews.index') ? 'active' : '' }}">Отзывы</a>
                    <a href="{{ route('contacts.index') }}" class="nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}">Контакты</a>
                    <a href="{{ route('contacts.index') }}#contact-order-form" class="btn btn-primary nav-menu-cta">Оставить заявку</a>
                </nav>
            </div>
            <a href="{{ route('contacts.index') }}" class="btn btn-primary header-cta">Оставить заявку</a>
        </div>
    </header>

    <main class="page-content">
        @yield('content')
    </main>

    <div id="photo-lightbox" class="photo-lightbox" data-photo-lightbox hidden>
        <div class="photo-lightbox__backdrop" data-photo-lightbox-close tabindex="-1"></div>
        <div class="photo-lightbox__dialog" role="dialog" aria-modal="true" aria-labelledby="photo-lightbox-caption">
            <button type="button" class="photo-lightbox__close" data-photo-lightbox-close aria-label="Закрыть">&times;</button>
            <figure class="photo-lightbox__figure">
                <img src="{{ asset('images/placeholders/placeholder.jpg') }}" alt="" class="photo-lightbox__img" id="photo-lightbox-img">
                <figcaption class="photo-lightbox__caption" id="photo-lightbox-caption"></figcaption>
            </figure>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container footer-grid">
            <section class="footer-brand">
                <h3 class="footer-brand-title"><a href="{{ route('home') }}">Фото-сон</a></h3>
                <p>Профессиональный фотосалон в Ростове-на-Дону. Создаём уникальные образы и сохраняем важные моменты вашей жизни.</p>
            </section>
            <section>
                <h4>Компания</h4>
                <nav class="footer-nav" aria-label="Компания">
                    <a href="{{ route('home') }}">Главная</a>
                    <a href="{{ route('services.index') }}">Услуги</a>
                    <a href="{{ route('gallery.index') }}">Галерея</a>
                    <a href="{{ route('reviews.index') }}">Отзывы</a>
                    <a href="{{ route('contacts.index') }}">Контакты</a>
                    <a href="{{ route('privacy.policy') }}">Политика обработки персональных данных</a>
                </nav>
            </section>
            <section>
                <h4>Контакты</h4>
                <p><a href="tel:+79163905565">+7 (916) 390-55-65</a></p>
                <p><a href="mailto:89163905565@mail.ru">89163905565@mail.ru</a></p>
                <p>г. Ростов-на-Дону, ул. Большая Садовая, д. 50</p>
                <p class="footer-hours">Пн–Пт: 10:00–20:00<br>Сб–Вс: 11:00–18:00</p>
            </section>
            <section class="footer-social">
                <h4>Соцсети</h4>
                <nav class="footer-social-nav" aria-label="Социальные сети">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="https://vk.com" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="ВКонтакте">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.07 2H8.93C3.33 2 2 3.33 2 8.93v6.14C2 20.67 3.33 22 8.93 22h6.14c5.6 0 6.93-1.33 6.93-6.93V8.93C22 3.33 20.67 2 15.07 2zm3.18 14.08h-1.25c-.46 0-.6-.37-1.43-1.2-.72-.67-1.04-.76-1.22-.76-.25 0-.32.07-.32.42v1.1c0 .3-.09.47-1.01.47-1.52 0-3.2-.92-4.38-2.64-1.78-2.55-2.27-4.47-2.27-4.86 0-.18.07-.35.42-.35h1.25c.31 0 .43.14.55.47.61 1.78 1.63 3.34 2.05 3.34.16 0 .23-.07.23-.48v-1.87c-.06-.99-.58-1.08-.58-1.43 0-.15.12-.3.32-.3h1.96c.26 0 .36.14.36.45v2.53c0 .26.12.36.19.36.16 0 .29-.1.58-.39 1.07-1.21 1.84-3.08 1.84-3.08.1-.2.24-.39.61-.39h1.25c.37 0 .45.19.37.45-.13.66-1.61 3.32-1.61 3.32-.13.21-.18.3 0 .54.13.18.56.55.85.88.53.58.94 1.06 1.05 1.4.1.34-.07.51-.44.51z"/></svg>
                    </a>
                    <a href="https://t.me" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Telegram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                    </a>
                </nav>
            </section>
        </div>
        <div class="container footer-bottom">
            <p>&copy; {{ now()->year }} Фото-сон. Все права защищены.</p>
        </div>
    </footer>
    @stack('scripts_vendor')
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
