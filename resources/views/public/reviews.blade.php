@extends('layouts.app')

@section('meta_title', 'Отзывы клиентов фотосалона «Фото-сон»')
@section('meta_description', 'Читайте отзывы клиентов о фотосалоне «Фото-сон» в Ростове-на-Дону: реальные впечатления, качество съёмки и уровень сервиса.')

@section('content')
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="container page-hero-content">
            <h1>Отзывы клиентов</h1>
            <p><a href="{{ route('home') }}">Главная</a> / Отзывы</p>
        </div>
    </section>

    <section class="section section-white" aria-labelledby="reviews-stats-heading">
        <h2 id="reviews-stats-heading" class="sr-only">Показатели фотосалона</h2>
        <div class="container stats-grid">
            <div><p class="stat-num">500+</p><p>Довольных клиентов</p></div>
            <div><p class="stat-num">1200+</p><p>Проведённых съёмок</p></div>
            <div><p class="stat-num">4.9</p><p>Средний рейтинг</p></div>
            <div><p class="stat-num">10+</p><p>Лет опыта</p></div>
        </div>
    </section>

    <section class="section section-alt" aria-labelledby="reviews-list-heading">
        <div class="container">
            <h2 id="reviews-list-heading" class="sr-only">Отзывы клиентов</h2>
            @if($reviews->isNotEmpty())
                <div class="grid grid-2 reviews-grid">
                    @foreach($reviews as $review)
                        @include('partials.review_card', [
                            'review' => $review,
                            'loopIndex' => $loop->index,
                            'extraClass' => null,
                            'truncate' => null,
                        ])
                    @endforeach
                </div>
            @else
                <p class="empty">Пока нет опубликованных отзывов.</p>
            @endif
        </div>
    </section>

    <section class="section cta-banner cta-banner--bottom reviews-page-cta" aria-labelledby="reviews-cta-heading">
        <div class="container text-center">
            <h2 id="reviews-cta-heading">Станьте частью наших довольных клиентов</h2>
            <p>Запишитесь на фотосессию и убедитесь в качестве наших услуг лично</p>
            <div class="reviews-page-cta__actions">
                <a href="https://yandex.ru/maps/" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer">Оставить отзыв</a>
                <a href="{{ route('contacts.index') }}" class="btn btn-light">Оставить заявку</a>
            </div>
        </div>
    </section>
@endsection