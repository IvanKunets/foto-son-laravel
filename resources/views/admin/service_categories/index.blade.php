@extends('layouts.admin')

@section('title', 'Категории услуг — Фото-сон')
@section('page_title', 'Категории услуг')

@section('content')
    @include('admin.services._tabs')

    <div class="admin-toolbar">
        <a href="{{ route('admin.service-categories.create') }}" class="btn">Добавить категорию</a>
    </div>

    <div class="admin-table-wrap admin-panel">
        <table class="admin-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Slug</th>
                <th>Порядок</th>
                <th>Услуг</th>
                <th>Видимость</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>{{ $category->sort_order }}</td>
                    <td>{{ $category->services_count }}</td>
                    <td>
                        @if ($category->is_visible)
                            <span class="admin-badge admin-badge--visible">Активна</span>
                        @else
                            <span class="admin-badge admin-badge--hidden">Скрыта</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.service-categories.edit', $category->id) }}" class="btn btn-secondary btn-sm">Изменить</a>
                        <form method="post" action="{{ route('admin.service-categories.destroy', $category->id) }}" class="inline-form" onsubmit="return confirm('Скрыть или удалить категорию?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">{{ $category->services_count > 0 ? 'Скрыть' : 'Удалить' }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Категории услуг пока не добавлены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $categories->withQueryString()->links('pagination.admin') }}
        </div>
    </div>
@endsection
