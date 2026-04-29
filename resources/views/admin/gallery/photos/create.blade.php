@extends('layouts.admin')

@section('title', 'Новое фото — Фото-сон')
@section('page_title', 'Загрузка фотографии')

@section('content')
    @if ($categories->isEmpty())
        <div class="admin-panel">
            <p>Сначала создайте хотя бы одну <a href="{{ route('admin.gallery.categories.create') }}">категорию галереи</a>.</p>
        </div>
    @else
    <form method="post" action="{{ route('admin.gallery.photos.store') }}" enctype="multipart/form-data" class="admin-form admin-panel">
        @csrf
        <div>
            <label for="category_id">Категория</label>
            <select id="category_id" name="category_id" required>
                <option value="">— выберите —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="image">Файл изображения</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            @error('image')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="alt_text">Подпись (alt)</label>
            <input type="text" id="alt_text" name="alt_text" value="{{ old('alt_text') }}" maxlength="255">
            @error('alt_text')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="sort_order">Порядок сортировки</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" required>
            @error('sort_order')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div class="checkbox-field">
            <input type="checkbox" id="is_visible" name="is_visible" value="1" @checked(old('is_visible', true))>
            <label for="is_visible">Показывать на сайте</label>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn">Загрузить</button>
            <a href="{{ route('admin.gallery', ['tab' => 'photos']) }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
    @endif
@endsection
