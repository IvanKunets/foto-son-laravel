@extends('layouts.admin')

@section('title', 'Дашборд — Фото-сон')
@section('page_title', 'Дашборд')

@section('content')
    @php
        $statusLabels = [
            'new' => 'Новая',
            'in_progress' => 'В работе',
            'done' => 'Выполнена',
            'cancelled' => 'Отменена',
        ];
    @endphp

    <div class="admin-card-grid admin-card-grid--dashboard">
        <article class="admin-metric admin-metric--dashboard">
            <p class="admin-metric__label">Новых заявок</p>
            <p class="admin-metric__value">{{ $ordersCount }}</p>
        </article>
        <article class="admin-metric admin-metric--dashboard">
            <p class="admin-metric__label">Услуг в базе</p>
            <p class="admin-metric__value">{{ $servicesCount }}</p>
        </article>
        <article class="admin-metric admin-metric--dashboard">
            <p class="admin-metric__label">Фотографий в галерее</p>
            <p class="admin-metric__value">{{ $photosCount }}</p>
        </article>
        <article class="admin-metric admin-metric--dashboard">
            <p class="admin-metric__label">Опубликованных отзывов</p>
            <p class="admin-metric__value">{{ $reviewsCount }}</p>
        </article>
    </div>

    <section class="admin-panel admin-panel--dashboard">
        <h2 class="admin-dashboard-orders-title">Последние заявки</h2>
        <div class="admin-table-wrap">
            <table class="admin-table admin-table--dashboard">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Услуга</th>
                    <th>Статус</th>
                    <th>Дата / время</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->client_phone }}</td>
                        <td>{{ $order->service?->title ?? '—' }}</td>
                        <td>
                            <span class="admin-status admin-status--{{ $order->status }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.index', ['page' => $orderPages[$order->id] ?? 1]) }}#order-{{ $order->id }}" class="admin-table__action">Открыть</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Заявок пока нет.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <p class="admin-panel__footer"><a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Все заявки</a></p>
    </section>
@endsection
