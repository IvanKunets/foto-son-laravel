<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $statusLabels = [
            'new' => 'Новая',
            'in_progress' => 'В работе',
            'done' => 'Выполнена',
            'cancelled' => 'Отменена',
        ];

        $status = (string) $request->query('status', 'all');
        if (!array_key_exists($status, $statusLabels)) {
            $status = 'all';
        }

        $search = trim((string) $request->query('search', ''));

        // Eager load услуги: одна связка на строку таблицы вместо отдельного запроса на каждую заявку
        $ordersQuery = Order::query()
            ->with('service')
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        if ($status !== 'all') {
            $ordersQuery->where('status', $status);
        }

        if ($search !== '') {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('client_name', 'like', '%' . $search . '%')
                    ->orWhere('client_phone', 'like', '%' . $search . '%');
            });
        }

        // paginate + withQueryString: фильтр и поиск сохраняются в URL при переходе по страницам
        $orders = $ordersQuery
            ->paginate(7)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'statusLabels', 'status', 'search'));
    }

    public function updateStatus(AdminOrderStatusRequest $request, Order $order): RedirectResponse
    {
        // Статус приходит только из разрешённого набора (см. AdminOrderStatusRequest)
        $order->update([
            'status' => $request->validated('status'),
        ]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Статус заявки обновлён.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Заявка удалена.');
    }
}
