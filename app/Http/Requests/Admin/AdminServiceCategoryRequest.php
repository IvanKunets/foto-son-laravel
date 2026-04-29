<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminServiceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:150'],
            'slug' => [
                'required',
                'string',
                'max:150',
                // Уникальный slug в таблице — стабильные URL и фильтры на публичной странице услуг
                Rule::unique('service_categories', 'slug')->ignore($categoryId),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (string) $this->input('name', '');
        $slugInput = trim((string) $this->input('slug', ''));
        $slug = $slugInput !== '' ? $slugInput : Str::slug($name);

        if ($slug === '') {
            $slug = 'service-category';
        }

        $this->merge([
            'slug' => Str::lower($slug),
            'is_visible' => $this->boolean('is_visible'),
            'sort_order' => $this->filled('sort_order') ? (int) $this->input('sort_order') : 0,
        ]);
    }
}
