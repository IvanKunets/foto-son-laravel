<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Белый список статусов: произвольная строка из формы не должна попасть в БД
            'status' => ['required', Rule::in(['new', 'in_progress', 'done', 'cancelled'])],
        ];
    }
}
