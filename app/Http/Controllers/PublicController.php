<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        // Главная: только видимые сущности, лимиты — чтобы страница оставалась лёгкой по объёму данных
        $services = Service::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(6)
            ->get();

        $photos = GalleryPhoto::query()
            ->where('is_visible', true)
            ->with('category')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        // Сортировка по дате отзыва (если задана) или по факту создания — та же логика, что на странице «Отзывы»
        $reviews = Review::query()
            ->where('is_visible', true)
            ->orderByRaw('COALESCE(reviewed_at, DATE(created_at)) DESC')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return view('public.index', compact('services', 'photos', 'reviews'));
    }

    public function services(): View
    {
        // Услуги подгружают category одним запросом связи — иначе для каждой карточки был бы отдельный запрос (N+1)
        $serviceCategories = ServiceCategory::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $services = Service::query()
            ->where('is_visible', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        return view('public.services', compact('services', 'serviceCategories'));
    }

    public function gallery(): View
    {
        // Вложенная выборка только видимых фото с сортировкой — одна загрузка дерева «категория → работы»
        $categories = GalleryCategory::query()
            ->where('is_visible', true)
            ->with(['photos' => function ($query) {
                $query->where('is_visible', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('public.gallery', compact('categories'));
    }

    public function reviews(): View
    {
        // Полный список отзывов с единой хронологией (дата публикации или дата создания записи)
        $reviews = Review::query()
            ->where('is_visible', true)
            ->orderByRaw('COALESCE(reviewed_at, DATE(created_at)) DESC')
            ->orderByDesc('id')
            ->get();

        return view('public.reviews', compact('reviews'));
    }

    public function contacts(): View
    {
        // Только видимые услуги для Select2 в форме — скрытые и тестовые не предлагаем клиенту
        $services = Service::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        return view('public.contacts', compact('services'));
    }

    public function privacyPolicy(): View
    {
        return view('public.privacy-policy');
    }

    public function storeOrder(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Новая заявка всегда в статусе new — дальнейшие переходы только из админки
        Order::create([
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'service_id' => $validated['service_id'],
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'comment' => $validated['comment'] ?? null,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Спасибо! Ваша заявка отправлена.');
    }
}
