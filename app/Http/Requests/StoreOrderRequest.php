<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Form Request: правила валидации на сервере обязательны — клиентские required/pattern легко обойти; здесь же фиксируем допустимые значения для БД и юридическое согласие
class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:150'],
            // Единый формат российского номера: предсказуемые данные для поиска в админке и меньше мусора в заявках
            'client_phone' => ['required', 'regex:/^(\+7|8)[\s\-]?\(?\d{3}\)?[\s\-]?\d{3}[\s\-]?\d{2}[\s\-]?\d{2}$/'],
            'service_id' => [
                'required',
                // Услуга должна существовать и быть видимой на сайте — нельзя подставить скрытый или удалённый id из формы
                Rule::exists('services', 'id')->where(fn ($q) => $q->where('is_visible', true)),
            ],
            // Дата в будущем: согласовано с бизнес-смыслом «записи на съёмку», пустое поле превращаем в null в prepareForValidation
            'preferred_date' => ['nullable', 'date', 'after:today'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            // Ограничение длины: защита от злоупотреблений и чрезмерных payload при хранении в БД
            'comment' => ['nullable', 'string', 'max:2000'],
            // accepted: без явного «да» заявка с персональными данными не проходит — требование 152-ФЗ и защита оператора
            'agree' => ['accepted'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Пустая строка из полей даты/времени не должна ломать nullable-валидацию — приводим к null для корректной записи в БД
        $preferred = $this->input('preferred_date');
        if ($preferred === '' || $preferred === null) {
            $this->merge(['preferred_date' => null]);
        }

        $preferredTime = $this->input('preferred_time');
        if ($preferredTime === '' || $preferredTime === null) {
            $this->merge(['preferred_time' => null]);
        }
    }

    public function messages(): array
    {
        return [
            'client_phone.regex' => 'Введите телефон в формате +7 (XXX) XXX-XX-XX',
            'comment.max' => 'Комментарий не может быть длиннее :max символов.',
        ];
    }
}
