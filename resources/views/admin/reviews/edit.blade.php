@extends('layouts.admin')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Редактирование отзыва — Фото-сон')
@section('page_title', 'Редактирование отзыва')

@section('content')
    <form method="post" action="{{ route('admin.reviews.update', $review->id) }}" class="admin-form admin-panel" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="author_name">Имя автора</label>
            <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $review->author_name) }}" required maxlength="150">
            @error('author_name')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="avatar">Фото клиента (аватар)</label>
            @if ($review->avatar && Storage::disk('public')->exists($review->avatar))
                <p class="admin-avatar-preview">
                    <img src="{{ Storage::url($review->avatar) }}" alt="">
                </p>
            @endif
            <input type="file" id="avatar" name="avatar" accept="image/*">
            <p class="field-hint">Оставьте пустым, чтобы не менять фото.</p>
            @error('avatar')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="service_name">Услуга</label>
            <input type="text" id="service_name" name="service_name" value="{{ old('service_name', $review->service_name) }}" maxlength="255" placeholder="Например: Семейная фотосессия">
            @error('service_name')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="reviewed_at">Дата отзыва</label>
            <input type="date" id="reviewed_at" name="reviewed_at" value="{{ old('reviewed_at', ($review->reviewed_at ?? $review->created_at)->format('Y-m-d')) }}">
            @error('reviewed_at')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="rating">Оценка</label>
            <select id="rating" name="rating" required>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected((int) old('rating', $review->rating) === $i)>{{ $i }}</option>
                @endfor
            </select>
            @error('rating')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="text">Текст отзыва</label>
            <textarea id="text" name="text" required>{{ old('text', $review->content) }}</textarea>
            @error('text')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div class="checkbox-field">
            <input type="checkbox" id="is_visible" name="is_visible" value="1" @checked(old('is_visible', $review->is_visible))>
            <label for="is_visible">Публиковать на сайте</label>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn">Сохранить</button>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
@endsection
