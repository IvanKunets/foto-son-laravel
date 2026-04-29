<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

// Валидация карточки услуги в админке: изображение и поля цены/сортировки должны соответствовать ограничениям БД и хранилища
class AdminServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // При создании обложка обязательна; при редактировании — опциональна (старое изображение остаётся, если файл не загрузили)
        $imageRules = $this->routeIs('admin.services.store')
            ? ['required', 'image', 'max:4096']
            : ['nullable', 'image', 'max:4096'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:service_categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => $imageRules,
            'is_visible' => ['sometimes', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Описание приходит как HTML с contenteditable: оставляем только безопасный набор тегов, остальное вырезаем (защита от XSS при выводе через {!! !!} на сайте)
        $allowedTags = '<p><br><ul><ol><li><strong><b><em><i>';
        $description = $this->input('description');

        $this->merge([
            'is_visible' => $this->boolean('is_visible'),
            'description' => is_string($description) ? trim(strip_tags($description, $allowedTags)) : $description,
        ]);
    }
}
