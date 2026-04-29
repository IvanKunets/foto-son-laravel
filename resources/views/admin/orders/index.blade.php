@extends('layouts.admin')

@section('title', 'Управление заявками — Фото-сон')
@section('page_title', 'Управление заявками')

@section('content')
    <div class="admin-orders-page">
        <section class="admin-orders-controls">
            <div class="admin-orders-controls__search">
                <form method="get" action="{{ route('admin.orders.index') }}" class="admin-orders-search" role="search" aria-label="Поиск заявок">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="search"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Поиск по имени или телефону"
                           aria-label="Поиск по имени или телефону">
                    <button type="submit" class="btn btn-secondary btn-sm">Поиск</button>
                </form>
            </div>

            <div class="admin-orders-controls__filters">
                <div class="admin-orders-filters" role="tablist" aria-label="Фильтр заявок по статусу">
                    <a href="{{ route('admin.orders.index', array_filter(['status' => 'all', 'search' => $search !== '' ? $search : null])) }}"
                       class="admin-filter-btn {{ $status === 'all' ? 'is-active' : '' }}"
                    >
                        Все
                    </a>
                    @foreach ($statusLabels as $value => $label)
                        <a href="{{ route('admin.orders.index', array_filter(['status' => $value, 'search' => $search !== '' ? $search : null])) }}"
                           class="admin-filter-btn {{ $status === $value ? 'is-active' : '' }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="admin-panel admin-orders-table-panel">
            <div class="admin-table-wrap">
                <table class="admin-table admin-orders-table">
                    <thead>
                    <tr>
                        <th class="admin-orders-col-no">№</th>
                        <th class="admin-orders-col-name">Имя</th>
                        <th class="admin-orders-col-phone">Телефон</th>
                        <th class="admin-orders-col-service">Услуга</th>
                        <th>Комментарий</th>
                        <th class="admin-orders-col-preferred-date">Дата / время</th>
                        <th class="admin-orders-col-status">Статус</th>
                        <th class="admin-orders-col-created">Создана</th>
                        <th class="admin-orders-col-actions">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        @php
                            $commentText = trim((string) ($order->comment ?? ''));
                        @endphp
                        <tr id="order-{{ $order->id }}">
                            <td class="admin-orders-col-no">{{ ($orders->firstItem() ?? 1) + $loop->index }}</td>
                            <td class="admin-orders-col-name">{{ $order->client_name }}</td>
                            <td class="admin-orders-col-phone">{{ $order->client_phone }}</td>
                            <td class="admin-order-service-cell admin-orders-col-service">
                                <span class="admin-order-service">{{ $order->service?->title ?? '—' }}</span>
                            </td>
                            <td class="admin-order-comment-cell">
                                @if ($commentText !== '')
                                    <span class="admin-order-comment-preview">{{ $commentText }}</span>
                                    <button type="button"
                                            class="admin-order-comment-more"
                                            data-comment-open
                                            data-comment-text="{{ $commentText }}">
                                        Подробнее
                                    </button>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="admin-orders-col-preferred-date">
                                @if ($order->preferred_date)
                                    {{ $order->preferred_date->format('d.m.Y') }}
                                    @if (! empty($order->preferred_time))
                                        <span class="admin-order-preferred-time">{{ $order->preferred_time }}</span>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td class="admin-orders-col-status">
                                <span class="admin-status admin-status--{{ $order->status }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                            </td>
                            <td class="admin-orders-col-created">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td class="admin-orders-col-actions">
                                <form method="post" action="{{ route('admin.orders.status', $order) }}" class="inline-form">
                                    @csrf
                                    <select name="status" aria-label="Статус заявки №{{ $order->id }}">
                                        @foreach ($statusLabels as $value => $label)
                                            <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm">Сохранить</button>
                                </form>
                                <form method="post" action="{{ route('admin.orders.destroy', $order) }}" class="inline-form" onsubmit="return confirm('Удалить заявку?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">
                {{ $orders->links('pagination.admin') }}
            </div>
        </section>
    </div>

    <div class="admin-comment-modal" data-comment-modal hidden aria-hidden="true">
        <div class="admin-comment-modal__backdrop" data-comment-close></div>
        <div class="admin-comment-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="admin-comment-modal-title">
            <div class="admin-comment-modal__head">
                <h2 id="admin-comment-modal-title">Комментарий к заявке</h2>
                <button type="button" class="admin-comment-modal__close" data-comment-close aria-label="Закрыть">×</button>
            </div>
            <p class="admin-comment-modal__text" data-comment-modal-text></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-comment-modal]');
            if (!modal) return;

            const modalText = modal.querySelector('[data-comment-modal-text]');
            const closeElements = modal.querySelectorAll('[data-comment-close]');

            const openModal = (text) => {
                if (!modalText) return;
                modalText.textContent = text;
                modal.hidden = false;
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.hidden = true;
                modal.setAttribute('aria-hidden', 'true');
                if (modalText) {
                    modalText.textContent = '';
                }
                document.body.style.overflow = '';
            };

            document.querySelectorAll('[data-comment-open]').forEach((button) => {
                button.addEventListener('click', () => {
                    const text = button.getAttribute('data-comment-text') || '';
                    openModal(text);
                });
            });

            closeElements.forEach((element) => {
                element.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.hidden) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
