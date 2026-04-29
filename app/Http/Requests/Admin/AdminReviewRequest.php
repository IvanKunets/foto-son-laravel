<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

// Проверка полей отзыва на сервере: рейтинг и обязательные поля не должны зависеть только от интерфейса админки
class AdminReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author_name' => ['required', 'string', 'max:150'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'text' => ['required', 'string'],
            'is_visible' => ['sometimes', 'boolean'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'service_name' => ['nullable', 'string', 'max:255'],
            'reviewed_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $reviewedAt = $this->input('reviewed_at');

        $this->merge([
            'is_visible' => $this->boolean('is_visible'),
            'reviewed_at' => ($reviewedAt === '' || $reviewedAt === null) ? null : $reviewedAt,
        ]);
    }
}
