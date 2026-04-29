@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('meta_title', 'Галерея работ фотосалона «Фото-сон»')
@section('meta_description', 'Галерея фотосалона «Фото-сон»: примеры студийных, семейных и портретных съёмок. Посмотрите наши работы и выберите формат фотосессии.')

@section('content')
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="container page-hero-content">
            <h1>Галерея работ</h1>
            <p><a href="{{ route('home') }}">Главная</a> / Галерея</p>
        </div>
    </section>

   <section class="section section-alt" aria-labelledby="gallery-content-heading">
        <div class="container">
            <h2 id="gallery-content-heading" class="sr-only">Каталог фотографий</h2>
            @if($categories->isNotEmpty())
                <div class="filters" data-gallery-filters>
                    <button class="filter-btn active" type="button" data-filter="all">Все категории</button>
                    @foreach($categories as $category)
                        <button class="filter-btn" type="button" data-filter="{{ $category->slug }}">{{ $category->name }}</button>
                    @endforeach
                </div>

                <div class="gallery-all">
                    @foreach($categories as $category)
                        @if($category->photos->isNotEmpty())
                            @foreach($category->photos as $photo)
                                <figure class="gallery-item" data-category="{{ $category->slug }}">
                                    <div class="gallery-item__media">
                                        @if ($photo->image)
                                            <button
                                                type="button"
                                                class="gallery-lightbox-trigger gallery-lightbox-trigger--fill"
                                                data-lightbox-src="{{ Storage::url($photo->image) }}"
                                                data-lightbox-alt="{{ $photo->alt ?? '' }}"
                                                aria-label="Открыть фото крупно"
                                            >
                                                <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->alt ?: 'Фото категории ' . $category->name }}" loading="lazy">
                                            </button>
                                        @else
                                            <div class="gallery-item__placeholder">Фото не загружено</div>
                                        @endif
                                    </div>
                                </figure>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <div class="gallery-load-more-wrap text-center">
                    <button type="button" class="btn btn-outline-dark" data-gallery-load-more>Загрузить еще</button>
                </div>
            @else
                <p class="empty">Категории галереи пока не добавлены.</p>
            @endif
        </div>
    </section>

    <section class="section cta-banner cta-banner--bottom" aria-labelledby="gallery-cta-heading">
        <div class="container text-center">
            <h2 id="gallery-cta-heading">Хотите такие же фотографии?</h2>
            <p>Запишитесь на съёмку прямо сейчас</p>
            <a href="{{ route('contacts.index') }}" class="btn btn-light">Оставить заявку</a>
        </div>
    </section>
@endsection
