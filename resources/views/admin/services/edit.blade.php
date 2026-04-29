@extends('layouts.admin')

@section('title', 'Редактирование услуги — Фото-сон')
@section('page_title', 'Редактирование услуги')

@section('content')
    @include('admin.services._tabs')

    <form method="post" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data" class="admin-form admin-panel">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Название</label>
            <input type="text" id="title" name="title" value="{{ old('title', $service->title) }}" required>
            @error('title')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="category_id">Категория</label>
            <select id="category_id" name="category_id" required>
                <option value="">— Выберите категорию —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $service->category_id) === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        @include('admin.services._description_editor', ['value' => old('description', $service->description), 'editorId' => 'description_editor_edit'])
        <div>
            <label for="price">Цена (₽)</label>
            <input type="number" id="price" name="price" value="{{ old('price', (int) $service->price) }}" min="0" step="1" required>
            @error('price')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="image">Изображение</label>
            @if ($service->image)
                <p><img src="{{ \Illuminate\Support\Facades\Storage::url($service->image) }}" alt="" class="admin-edit-preview"></p>
                <p>Текущее фото. Загрузите новое, чтобы заменить.</p>
            @endif
            <input type="file" id="image" name="image" accept="image/*">
            @error('image')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="sort_order">Порядок сортировки</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0" required>
            @error('sort_order')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div class="checkbox-field">
            <input type="checkbox" id="is_visible" name="is_visible" value="1" @checked(old('is_visible', $service->is_visible))>
            <label for="is_visible">Показывать на сайте</label>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn">Сохранить</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-rich-editor]').forEach((editor) => {
                const content = editor.querySelector('[data-rich-editor-content]');
                const textarea = editor.querySelector('textarea[name="description"]');
                if (!content || !textarea) return;

                // innerHTML сохраняет разметку списков и абзацев; XSS на публичной части снимается strip_tags в AdminServiceRequest
                const sync = () => {
                    textarea.value = content.innerHTML.trim();
                };

                editor.querySelectorAll('.rich-editor__btn').forEach((button) => {
                    button.addEventListener('click', () => {
                        const command = button.getAttribute('data-command');
                        const value = button.getAttribute('data-value');
                        content.focus();
                        if (command === 'formatBlock') {
                            document.execCommand(command, false, value || 'p');
                        } else {
                            document.execCommand(command, false);
                        }
                        sync();
                    });
                });

                content.addEventListener('input', sync);
                sync();
            });
        });
    </script>
@endsection
