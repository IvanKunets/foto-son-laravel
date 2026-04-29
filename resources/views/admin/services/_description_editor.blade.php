@php
    $editorId = $editorId ?? 'description_editor';
    $value = (string) ($value ?? '');
@endphp
<div>
    <label for="{{ $editorId }}">Описание</label>
    <div class="rich-editor" data-rich-editor>
        <div class="rich-editor__toolbar" role="toolbar" aria-label="Форматирование описания">
            <button type="button" class="rich-editor__btn" data-command="formatBlock" data-value="p">Абзац</button>
            <button type="button" class="rich-editor__btn" data-command="insertUnorderedList">Маркированный список</button>
            <button type="button" class="rich-editor__btn" data-command="insertOrderedList">Нумерованный список</button>
            <button type="button" class="rich-editor__btn" data-command="bold"><strong>B</strong></button>
            <button type="button" class="rich-editor__btn" data-command="italic"><em>I</em></button>
        </div>
        {{-- Доверенный контент из БД для правки в админке; на публичном сайте тот же HTML дополнительно фильтруется при сохранении --}}
        <div id="{{ $editorId }}" class="rich-editor__content" contenteditable="true" data-rich-editor-content>{!! $value !!}</div>
        <textarea id="description" name="description" class="rich-editor__textarea" hidden>{{ $value }}</textarea>
    </div>
    <p class="field-hint">Поддерживаются абзацы, маркированные и нумерованные списки.</p>
    @error('description')<p class="field-error">{{ $message }}</p>@enderror
</div>
