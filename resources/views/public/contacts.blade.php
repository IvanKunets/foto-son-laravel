@extends('layouts.app')

{{-- Select2 подключается только на этой странице: поиск по длинному списку услуг без перегрузки остальных разделов --}}
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@push('scripts_vendor')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
@endpush

@section('meta_title', 'Контакты фотосалона «Фото-сон» — Ростов-на-Дону')
@section('meta_description', 'Контакты фотосалона «Фото-сон»: адрес в Ростове-на-Дону, телефон, email, график работы и форма онлайн-заявки на фотосессию.')

@section('content')
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="container page-hero-content">
            <h1>Контакты</h1>
            <p><a href="{{ route('home') }}">Главная</a> / Контакты</p>
        </div>
    </section>

    <section class="section section-white contacts-section">
        <div class="container contact-grid">
            <aside class="contacts-info">
                <h2 class="contacts-info__title">Как с нами связаться</h2>

                <div class="contacts-info__block">
                    <h3>Телефон</h3>
                    <a href="tel:+79163905565" class="contacts-info__accent">+7 (916) 390-55-65</a>
                    <p class="contacts-info__hint">Ежедневно с 10:00 до 20:00</p>
                </div>

                <div class="contacts-info__block">
                    <h3>Email</h3>
                    <a href="mailto:89163905565@mail.ru" class="contacts-info__accent">89163905565@mail.ru</a>
                    <p class="contacts-info__hint">Ответим в течение 2 часов</p>
                </div>

                <div class="contacts-info__block">
                    <h3>Адрес студии</h3>
                    <p class="contacts-info__text">г. Ростов-на-Дону, ул. Большая Садовая, д. 50</p>
                </div>

                <div class="contacts-info__block">
                    <h3>Режим работы</h3>
                    <p class="contacts-info__text">Пн-Пт: 10:00-20:00, Сб-Вс: 11:00-18:00</p>
                </div>

                <div class="contacts-info__block contacts-info__social">
                    <h3>Социальные сети</h3>
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
                </div>
            </aside>

            <div class="card contacts-form-card" id="contact-order-form">
                <h2>Оставить заявку</h2>

                @if(session('success'))
                    <p class="success-message">{{ session('success') }}</p>
                @endif
                @if($errors->any())
                    <div class="error-message">
                        <p>Пожалуйста, проверьте корректность заполнения формы:</p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('order.store') }}" method="post" class="order-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <label for="client_name">Ваше имя *</label>
                    <input class="input" id="client_name" name="client_name" type="text" value="{{ old('client_name') }}" required maxlength="150">

                    <label for="client_phone">Телефон *</label>
                    <input class="input" id="client_phone" name="client_phone" type="tel" value="{{ old('client_phone') }}" required maxlength="30" placeholder="+7 (XXX) XXX-XX-XX">

                    <label for="service_id">Услуга *</label>
                    <select class="input select2-order-service" id="service_id" name="service_id" data-placeholder="— Выберите услугу —" required>
                        <option value="">— Выберите услугу —</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected((string) old('service_id') === (string) $service->id)>
                                {{ $service->title }} ({{ (int) $service->price }} руб.)
                            </option>
                        @endforeach
                    </select>

                    <label for="preferred_date">Желаемая дата съемки (необязательно)</label>
                    <input class="input" id="preferred_date" name="preferred_date" type="date" value="{{ old('preferred_date') }}">

                    <label for="preferred_time">Желаемое время (необязательно)</label>
                    <input class="input" id="preferred_time" name="preferred_time" type="time" value="{{ old('preferred_time') }}">

                    <label for="comment">Комментарий к заявке</label>
                    <textarea class="input" id="comment" name="comment" rows="5" placeholder="Опишите формат съемки, количество участников и пожелания">{{ old('comment') }}</textarea>

                    {{-- required на клиенте + accepted на сервере: явное согласие на обработку ПДн до отправки заявки --}}
                    <p class="order-form__consent">
                        <label class="order-form__consent-label">
                            <input type="checkbox" name="agree" value="1" @checked(old('agree')) required>
                            <span>Я соглашаюсь на обработку персональных данных и подтверждаю, что ознакомлен(а) с <a href="{{ route('privacy.policy') }}" class="order-form__consent-link">политикой в отношении обработки персональных данных</a>.</span>
                        </label>
                    </p>

                    <button class="btn btn-primary btn-block" type="submit">Отправить заявку</button>
                </form>
            </div>
        </div>
    </section>

    <section class="section section-alt contacts-map-section" aria-labelledby="contacts-map-heading">
        <div class="container">
            <h2 id="contacts-map-heading" class="sr-only">Карта проезда</h2>
            <div class="map-placeholder contacts-map-embed">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa006ad00f4f3d8f5150b95f2bdd86ae46ab2149762d102f1c5f78bfb6d9006f4&amp;source=constructor"
                    loading="lazy"
                    title="Карта проезда до фотосалона Фото-сон"
                ></iframe>
            </div>
        </div>
    </section>
@endsection