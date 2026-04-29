<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminServiceCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.service_categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.service_categories.create');
    }

    public function store(AdminServiceCategoryRequest $request): RedirectResponse
    {
        ServiceCategory::create([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug'),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ]);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Категория услуги создана.');
    }

    public function edit(int $id): View
    {
        $category = ServiceCategory::query()->findOrFail($id);

        return view('admin.service_categories.edit', compact('category'));
    }

    public function update(AdminServiceCategoryRequest $request, int $id): RedirectResponse
    {
        $category = ServiceCategory::query()->findOrFail($id);
        $category->update([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug'),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ]);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Категория услуги обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = ServiceCategory::query()->withCount('services')->findOrFail($id);

        if ($category->services_count > 0) {
            $category->update(['is_visible' => false]);

            return redirect()
                ->route('admin.service-categories.index')
                ->with('success', 'Категория скрыта, так как к ней привязаны услуги.');
        }

        $category->delete();

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Категория услуги удалена.');
    }
}
