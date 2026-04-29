<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminGalleryCategoryRequest;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminGalleryCategoryController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.gallery', ['tab' => 'categories']);
    }

    public function create(): View
    {
        return view('admin.gallery.categories.create');
    }

    public function store(AdminGalleryCategoryRequest $request): RedirectResponse
    {
        GalleryCategory::create([
            'name' => $request->validated('name'),
            'slug' => $this->uniqueSlug($request->validated('name')),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ]);

        return redirect()
            ->route('admin.gallery', ['tab' => 'categories'])
            ->with('success', 'Категория создана.');
    }

    public function edit(int $id): View
    {
        $category = GalleryCategory::query()->findOrFail($id);

        return view('admin.gallery.categories.edit', compact('category'));
    }

    public function update(AdminGalleryCategoryRequest $request, int $id): RedirectResponse
    {
        $category = GalleryCategory::query()->findOrFail($id);

        $category->update([
            'name' => $request->validated('name'),
            'slug' => $this->uniqueSlug($request->validated('name'), $category->id),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ]);

        return redirect()
            ->route('admin.gallery', ['tab' => 'categories'])
            ->with('success', 'Категория обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        GalleryCategory::query()->findOrFail($id)->delete();

        return redirect()
            ->route('admin.gallery', ['tab' => 'categories'])
            ->with('success', 'Категория удалена.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'category';
        }

        $base = Str::limit($base, 80, '');
        $slug = $base;
        $counter = 1;

        while (GalleryCategory::query()
            ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = Str::limit($base.'-'.$counter, 100, '');
            $counter++;
        }

        return $slug;
    }
}
