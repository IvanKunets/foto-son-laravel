@extends('layouts.admin')

@section('title', 'Услуги — Фото-сон')
@section('page_title', 'Управление услугами')

@section('content')
    @include('admin.services._tabs')

    <div class="admin-toolbar">
        <a href="{{ route('admin.services.create') }}" class="btn">Добавить услугу</a>
    </div>

    <div class="admin-table-wrap admin-panel">
        <table class="admin-table">
            <thead>
            <tr>
                <th></th>
                <th>Название</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Порядок</th>
                <th>Видимость</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>
                        @if ($service->image)
                            <img class="admin-thumb" src="{{ asset(\Illuminate\Support\Facades\Storage::url($service->image)) }}" alt="">
                        @else
                            <span class="admin-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $service->title }}</td>
                    <td>{{ $service->category?->name ?? '—' }}</td>
                    <td>{{ $service->price !== null ? number_format((float) $service->price, 2, '.', ' ') . ' ₽' : '—' }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        @if ($service->is_visible)
                            <span class="admin-badge admin-badge--visible">На сайте</span>
                        @else
                            <span class="admin-badge admin-badge--hidden">Скрыта</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-secondary btn-sm">Изменить</a>
                        <form method="post" action="{{ route('admin.services.toggle', $service->id) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">{{ $service->is_visible ? 'Скрыть' : 'Показать' }}</button>
                        </form>
                        <form method="post" action="{{ route('admin.services.destroy', $service->id) }}" class="inline-form" onsubmit="return confirm('Удалить услугу?');">
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
            {{ $services->withQueryString()->links('pagination.admin') }}
        </div>
    </div>
@endsection
