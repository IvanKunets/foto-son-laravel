@extends('layouts.admin')

@section('title', 'Галерея — Фото-сон')
@section('page_title', 'Управление галереей')

@section('content')
    <nav class="admin-tabs" aria-label="Разделы галереи">
        <a href="{{ route('admin.gallery', ['tab' => 'categories']) }}" class="{{ $tab === 'categories' ? 'is-active' : '' }}">Категории</a>
        <a href="{{ route('admin.gallery', ['tab' => 'photos']) }}" class="{{ $tab === 'photos' ? 'is-active' : '' }}">Фотографии</a>
    </nav>

    <div id="panel-categories" class="tab-panel {{ $tab === 'categories' ? 'is-active' : '' }}">
        <div class="admin-toolbar">
            <a href="{{ route('admin.gallery.categories.create') }}" class="btn">Добавить категорию</a>
        </div>
        <div class="admin-table-wrap admin-panel">
            <table class="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Порядок</th>
                    <th>Видимость</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            @if ($category->is_visible)
                                <span class="admin-badge admin-badge--visible">Видна</span>
                            @else
                                <span class="admin-badge admin-badge--hidden">Скрыта</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.gallery.categories.edit', $category->id) }}" class="btn btn-secondary btn-sm">Изменить</a>
                            <form method="post" action="{{ route('admin.gallery.categories.destroy', $category->id) }}" class="inline-form" onsubmit="return confirm('Удалить категорию и все фото в ней?');">
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
                {{ $categories->withQueryString()->links('pagination.admin') }}
            </div>
        </div>
    </div>

    <div id="panel-photos" class="tab-panel {{ $tab === 'photos' ? 'is-active' : '' }}">
        <div class="admin-toolbar">
            <a href="{{ route('admin.gallery.photos.create') }}" class="btn">Добавить фото</a>
        </div>
        <div class="admin-table-wrap admin-panel">
            <table class="admin-table">
                <thead>
                <tr>
                    <th></th>
                    <th>Категория</th>
                    <th>Alt</th>
                    <th>Порядок</th>
                    <th>Видимость</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($photos as $photo)
                    <tr>
                        <td>
                            @if ($photo->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" alt="{{ $photo->alt }}" class="admin-thumb-preview">
                            @else
                                нет фото
                            @endif
                        </td>
                        <td>{{ $photo->category?->name ?? '—' }}</td>
                        <td>{{ $photo->alt ?? '—' }}</td>
                        <td>{{ $photo->sort_order }}</td>
                        <td>
                            @if ($photo->is_visible)
                                <span class="admin-badge admin-badge--visible">Видна</span>
                            @else
                                <span class="admin-badge admin-badge--hidden">Скрыта</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.gallery.photos.edit', $photo->id) }}" class="btn btn-secondary btn-sm">Редактировать</a>
                            <form method="post" action="{{ route('admin.gallery.photos.toggle', $photo->id) }}" class="inline-form">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">{{ $photo->is_visible ? 'Скрыть' : 'Показать' }}</button>
                            </form>
                            <form method="post" action="{{ route('admin.gallery.photos.destroy', $photo->id) }}" class="inline-form" onsubmit="return confirm('Удалить фото?');">
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
                {{ $photos->withQueryString()->links('pagination.admin') }}
            </div>
        </div>
    </div>
@endsection
