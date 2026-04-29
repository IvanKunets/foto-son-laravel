<nav class="admin-tabs" aria-label="Разделы услуг">
    <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">Услуги</a>
    <a href="{{ route('admin.service-categories.index') }}" class="{{ request()->routeIs('admin.service-categories.*') ? 'is-active' : '' }}">Категории</a>
</nav>
