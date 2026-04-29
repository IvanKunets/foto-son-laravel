@extends('layouts.admin')

@section('title', 'Редактирование категории услуг — Фото-сон')
@section('page_title', 'Редактирование категории услуг')

@section('content')
    @include('admin.services._tabs')

    <form method="post" action="{{ route('admin.service-categories.update', $category->id) }}" class="admin-form admin-panel">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Название</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="150" required>
            @error('name')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" maxlength="150" required>
            @error('slug')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="sort_order">Порядок сортировки</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
            @error('sort_order')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div class="checkbox-field">
            <input type="checkbox" id="is_visible" name="is_visible" value="1" @checked(old('is_visible', $category->is_visible))>
            <label for="is_visible">Показывать категорию</label>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn">Сохранить</button>
            <a href="{{ route('admin.service-categories.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
@endsection
