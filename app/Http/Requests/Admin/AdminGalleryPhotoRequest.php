<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminGalleryPhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Новое фото обязательно при создании; при правке можно оставить файл прежним
        $imageRules = $this->routeIs('admin.gallery.photos.store')
            ? ['required', 'image', 'max:4096']
            : ['nullable', 'image', 'max:4096'];

        return [
            'category_id' => ['required', 'exists:gallery_categories,id'],
            'image' => $imageRules,
            'alt_text' => ['nullable', 'string', 'max:255'],
            'is_visible' => ['sometimes', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_visible' => $this->boolean('is_visible'),
        ]);
    }
}
