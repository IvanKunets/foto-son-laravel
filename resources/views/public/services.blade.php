@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('meta_title', 'Услуги фотосалона «Фото-сон» — Ростов-на-Дону')
@section('meta_description', 'Услуги фотосалона «Фото-сон»: студийные, семейные и портретные фотосессии, профессиональная обработка и доступные цены в Ростове-на-Дону.')

@section('content')
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="container page-hero-content">
            <h1>Услуги фотосалона</h1>
            <p><a href="{{ route('home') }}">Главная</a> / Услуги</p>
        </div>
    </section>

    <section class="section section-white">
        <div class="container">
            <h2 class="section-title">Наши услуги</h2>
        @if($services->isNotEmpty())
                <div class="filters services-filters" data-services-filters>
                    <button class="filter-btn active" type="button" data-service-filter="all">Все услуги</button>
                    @foreach($serviceCategories as $category)
                        <button class="filter-btn" type="button" data-service-filter="{{ $category->slug }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                <div class="grid grid-3 services-list">
                @foreach($services as $service)
                        <article class="card service-card service-card--listing" data-service-category="{{ $service->category->slug ?? 'uncategorized' }}">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" loading="lazy">
                            @else
                                <div class="service-card__no-image">Фото не добавлено</div>
                            @endif
                            <h3>{{ $service->title }}</h3>
                            {{-- HTML из админки проходит strip_tags на сервере; {!! !!} нужен для абзацев и списков из редактора --}}
                            <div class="muted service-card__desc">{!! $service->description ?: '<p>Описание услуги скоро появится.</p>' !!}</div>
                            <p class="price">от {{ $service->price !== null ? number_format((int) $service->price, 0, '', ' ') : '0' }} ₽</p>
                            <a href="{{ route('contacts.index') }}" class="service-card__more">Подробнее</a>
                    </article>
                @endforeach
            </div>
                <div class="gallery-load-more-wrap text-center">
                    <button type="button" class="btn btn-outline-dark" data-service-load-more hidden>Загрузить еще</button>
                </div>
        @else
                <p class="empty">Список услуг пуст.</p>
        @endif
        </div>
    </section>

    <section class="section cta-banner cta-banner--bottom" aria-labelledby="cta-services-heading">
        <div class="container text-center">
            <h2 id="cta-services-heading">Не нашли нужную услугу?</h2>
            <p>Оставьте заявку — мы свяжемся с вами и подберём вариант</p>
            <a href="{{ route('contacts.index') }}" class="btn btn-light">Получить консультацию</a>
        </div>
    </section>
@endsection
