@php
    $reviewDate = $review->reviewed_at ?? $review->created_at;
    $reviewSourceLinks = [
        ['label' => 'Яндекс.Карты', 'url' => 'https://yandex.ru/maps/'],
        ['label' => '2ГИС', 'url' => 'https://2gis.ru/'],
        ['label' => 'Google Maps', 'url' => 'https://maps.google.com/'],
    ];
    $reviewSource = $reviewSourceLinks[$loopIndex % count($reviewSourceLinks)];
@endphp
<article class="card review-card{{ !empty($extraClass) ? ' ' . $extraClass : '' }}">
    <h3 class="sr-only">Отзыв клиента {{ $review->author_name }}</h3>

    <div class="review-card__head">
        @include('partials.review_avatar', ['review' => $review])
        <div class="review-card__head-main">
            <p class="review-card__name">{{ $review->author_name }}</p>
            <div class="review-card__rating-row">
                <p class="rating">
                    <span aria-hidden="true">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</span>
                    <span class="sr-only">Оценка {{ $review->rating }} из 5</span>
                </p>
                <div class="review-card__meta-actions">
                    <time class="review-card__date" datetime="{{ $reviewDate->toIso8601String() }}">{{ $reviewDate->format('d.m.Y') }}</time>
                    <a href="{{ $reviewSource['url'] }}" class="review-card__source-btn" target="_blank" rel="noopener noreferrer">{{ $reviewSource['label'] }}</a>
                </div>
            </div>
            @if (filled($review->service_name))
                <p class="review-card__service">{{ $review->service_name }}</p>
            @endif
        </div>
    </div>
    <p class="muted review-card__text">
        {{ isset($truncate) && $truncate ? \Illuminate\Support\Str::limit($review->content, $truncate) : $review->content }}
    </p>
</article>