@extends('layouts.admin')

@section('title', 'Отзывы — Фото-сон')
@section('page_title', 'Управление отзывами')

@section('content')
    <div class="admin-toolbar">
        <a href="{{ route('admin.reviews.create') }}" class="btn">Добавить отзыв</a>
    </div>

    <div class="admin-table-wrap admin-panel">
        <table class="admin-table">
            <thead>
            <tr>
                <th>Автор</th>
                <th>Рейтинг</th>
                <th>Текст</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->author_name }}</td>
                    <td class="stars" aria-label="Оценка {{ $review->rating }} из 5">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($review->content, 80) }}</td>
                    <td>
                        @if ($review->is_visible)
                            <span class="admin-badge admin-badge--visible">На сайте</span>
                        @else
                            <span class="admin-badge admin-badge--hidden">Скрыт</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-secondary btn-sm">Изменить</a>
                        <form method="post" action="{{ route('admin.reviews.toggle', $review->id) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">{{ $review->is_visible ? 'Скрыть' : 'Показать' }}</button>
                        </form>
                        <form method="post" action="{{ route('admin.reviews.destroy', $review->id) }}" class="inline-form" onsubmit="return confirm('Удалить отзыв?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $reviews->withQueryString()->links('pagination.admin') }}
        </div>
    </div>
@endsection
