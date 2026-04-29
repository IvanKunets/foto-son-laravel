<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // Счётчики и «срез» заявок для быстрого обзора без загрузки всей таблицы orders
        $ordersCount = Order::query()->where('status', 'new')->count();
        $servicesCount = Service::query()->count();
        $photosCount = GalleryPhoto::query()->count();
        $reviewsCount = Review::query()->where('is_visible', true)->count();
        $perPage = 7;

        // with('service'): название услуги в таблице без N+1; приоритет new в сортировке — сначала несрочные входящие
        $recentOrders = Order::query()
            ->with('service')
            ->whereIn('status', ['new', 'in_progress'])
            ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(7)
            ->get();

        // Номер страницы в списке заявок (пагинация 7) для ссылки «открыть в общем списке» — позиция считается по глобальной очереди, как в админ-таблице
        $orderPages = [];
        foreach ($recentOrders as $order) {
            $position = Order::query()
                ->where(function ($query) use ($order) {
                    $query->where('created_at', '>', $order->created_at)
                        ->orWhere(function ($sameDate) use ($order) {
                            $sameDate->where('created_at', '=', $order->created_at)
                                ->where('id', '>', $order->id);
                        });
                })
                ->count() + 1;

            $orderPages[$order->id] = (int) floor(($position - 1) / $perPage) + 1;
        }

        return view('admin.dashboard', compact(
            'ordersCount',
            'servicesCount',
            'photosCount',
            'reviewsCount',
            'recentOrders',
            'orderPages'
        ));
    }
}
