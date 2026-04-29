@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('meta_title', 'Фото-сон — фотосалон в Ростове-на-Дону')
@section('meta_description', 'Фото-сон — профессиональный фотосалон в Ростове-на-Дону: портретные, семейные и студийные фотосессии, ретушь и печать снимков.')

@section('content')
    <section class="hero hero--home" aria-labelledby="hero-heading">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 id="hero-heading">Ваши моменты — наше искусство</h1>
            <p><span class="hero__subtitle-text">Профессиональный фотосалон в Ростове-на-Дону. Создаём уникальные образы и<span class="hero__subtitle-break"><br></span>сохраняем важные моменты вашей жизни.</span></p>
            <div class="hero-actions">
                <a href="{{ route('services.index') }}" class="btn btn-primary">Смотреть услуги</a>
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-light">Наши работы</a>
            </div>
        </div>
    </section>

    <section class="section section-alt home-about" aria-labelledby="about-heading">
        <div class="container home-about__grid">
            <div class="home-about__text">
                <h2 id="about-heading">О нас</h2>
                <p>Фото-сон — это команда профессиональных фотографов с более чем 10-летним опытом работы. Мы специализируемся на создании высококачественных фотографий, которые передают эмоции и рассказывают истории.</p>
                <p>Наш фотосалон оснащен современным оборудованием, а индивидуальный подход к каждому клиенту гарантирует уникальный результат, который превосходит ожидания.</p>
                <p>Мы создаём не просто фотографии — мы создаём воспоминания, которые останутся с вами навсегда.</p>
                <ul class="home-about__features">
                    <li class="home-about__feature">
                        <div class="home-about__feature-icon" aria-hidden="true">
                            <svg class="home-about__feature-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L23.09 15.26L33 16.27L26.5 22.27L28.18 32.02L20 27.27L11.82 32.02L13.5 22.27L7 16.27L16.91 15.26L20 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="home-about__feature-label">10+ лет опыта</p>
                    </li>
                    <li class="home-about__feature">
                        <div class="home-about__feature-icon" aria-hidden="true">
                            <svg class="home-about__feature-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="6" y="10" width="28" height="20" rx="2" stroke="currentColor" stroke-width="2"/>
                                <circle cx="20" cy="20" r="5" stroke="currentColor" stroke-width="2"/>
                                <path d="M13 10V7C13 6.44772 13.4477 6 14 6H26C26.5523 6 27 6.44772 27 7V10" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <p class="home-about__feature-label">Высокое качество</p>
                    </li>
                    <li class="home-about__feature">
                        <div class="home-about__feature-icon" aria-hidden="true">
                            <svg class="home-about__feature-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4L24 14L34 16L27 23L29 33L20 28L11 33L13 23L6 16L16 14L20 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="20" cy="20" r="4" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <p class="home-about__feature-label">Индивидуальный подход</p>
                    </li>
                </ul>
            </div>
            <figure class="home-about__figure">
                <img
                    src="{{ asset('images/gallery/o-nas.jpg') }}"
                    alt="Фотосалон «Фото-сон»"
                    width="600"
                    height="720"
                    loading="lazy"
                    class="home-about__img"
                >
            </figure>
        </div>
    </section>

    <section class="section section-white home-services" aria-labelledby="services-heading">
        <div class="container">
            <h2 id="services-heading" class="section-title">Наши услуги</h2>
            @if ($services->isNotEmpty())
                <div class="home-services__grid">
                    @foreach ($services as $service)
                        <article class="card service-card service-card--home">
                            @if ($service->image)
                                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" loading="lazy" class="service-card__thumb">
                            @else
                                <div class="service-card__no-image">Фото не добавлено</div>
                            @endif
                            <h3>{{ $service->title }}</h3>
                            <p class="muted">{{ \Illuminate\Support\Str::limit(strip_tags($service->description ?: 'Профессиональная фотосессия с индивидуальным подходом.'), 120) }}</p>
                            <p class="price">от {{ $service->price !== null ? number_format((int) $service->price, 0, '', ' ') : '0' }} ₽</p>
                            <a href="{{ route('services.index') }}" class="service-card__more">Подробнее →</a>
                        </article>
                    @endforeach
                </div>
                <p class="home-services__footer">
                    <a href="{{ route('services.index') }}" class="btn btn-primary">Все услуги</a>
                </p>
            @else
                <p class="empty">Услуги пока не добавлены.</p>
            @endif
        </div>
    </section>

    <section class="section section-alt home-showcase" aria-labelledby="showcase-heading">
        <div class="container">
            <h2 id="showcase-heading" class="section-title">Примеры работ</h2>
            @if ($photos->isNotEmpty())
                <div class="home-showcase__grid">
                    @foreach ($photos as $photo)
                        <figure class="home-showcase__item home-showcase__tile gallery-item">
                            @if ($photo->image)
                                <button
                                    type="button"
                                    class="gallery-lightbox-trigger gallery-lightbox-trigger--fill"
                                    data-lightbox-src="{{ Storage::url($photo->image) }}"
                                    data-lightbox-alt="{{ $photo->alt ?? '' }}"
                                    aria-label="Открыть фото крупно"
                                >
                                    <img
                                        src="{{ Storage::url($photo->image) }}"
                                        alt="{{ $photo->alt ?: 'Работа фотосалона Фото-сон' }}"
                                        loading="lazy"
                                    >
                                </button>
                            @else
                                <div class="gallery-item__placeholder">Фото не загружено</div>
                            @endif
                        </figure>
                    @endforeach
                </div>
                <p class="home-showcase__footer">
                    <a href="{{ route('gallery.index') }}" class="btn btn-outline-dark">Смотреть все работы</a>
                </p>
            @else
                <p class="empty">Фотографии пока не добавлены.</p>
            @endif
        </div>
    </section>

    <section class="section section-white home-reviews" aria-labelledby="reviews-heading">
        <div class="container">
            <h2 id="reviews-heading" class="section-title">Отзывы клиентов</h2>
            @if ($reviews->isNotEmpty())
                <div class="home-reviews__strip">
                    @foreach ($reviews as $review)
                        @include('partials.review_card', [
                            'review' => $review,
                            'loopIndex' => $loop->index,
                            'extraClass' => 'review-card--home',
                            'truncate' => 220,
                        ])
                    @endforeach
                </div>
                <p class="home-reviews__footer">
                    <a href="{{ route('reviews.index') }}" class="home-reviews__all">Все отзывы</a>
                </p>
            @else
                <p class="empty">Пока нет опубликованных отзывов.</p>
            @endif
        </div>
    </section>

    <section class="section cta-banner cta-banner--bottom" aria-labelledby="cta-bottom-heading">
        <div class="container text-center">
            <h2 id="cta-bottom-heading">Запишитесь прямо сейчас</h2>
            <p>Забронируйте свою фотосессию сегодня и получите скидку 10% на первый заказ</p>
            <a href="{{ route('contacts.index') }}" class="btn btn-light">Оставить заявку</a>
        </div>
    </section>
@endsection
