<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminGalleryPhotoRequest;
use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminGalleryPhotoController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.gallery', ['tab' => 'photos']);
    }

    public function create(): View
    {
        $categories = GalleryCategory::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.gallery.photos.create', compact('categories'));
    }

    public function store(AdminGalleryPhotoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        GalleryPhoto::create([
            'category_id' => $validated['category_id'],
            'image' => $request->file('image')->store('gallery', 'public'),
            'alt' => $validated['alt_text'] ?? null,
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()
            ->route('admin.gallery', ['tab' => 'photos'])
            ->with('success', 'Фотография добавлена.');
    }

    public function edit(int $id): View
    {
        $photo = GalleryPhoto::query()->findOrFail($id);

        $categories = GalleryCategory::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.gallery.photos.edit', compact('photo', 'categories'));
    }

    public function update(AdminGalleryPhotoRequest $request, int $id): RedirectResponse
    {
        $photo = GalleryPhoto::query()->findOrFail($id);
        $validated = $request->validated();

        $payload = [
            'category_id' => $validated['category_id'],
            'alt' => $validated['alt_text'] ?? null,
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $validated['sort_order'],
        ];

        if ($request->hasFile('image')) {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            $payload['image'] = $request->file('image')->store('gallery', 'public');
        }

        $photo->update($payload);

        return redirect()
            ->route('admin.gallery', ['tab' => 'photos'])
            ->with('success', 'Фотография обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $photo = GalleryPhoto::query()->findOrFail($id);

        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()
            ->route('admin.gallery', ['tab' => 'photos'])
            ->with('success', 'Фотография удалена.');
    }

    public function toggleVisible(int $id): RedirectResponse
    {
        $photo = GalleryPhoto::query()->findOrFail($id);
        $photo->update(['is_visible' => ! $photo->is_visible]);

        return redirect()
            ->route('admin.gallery', ['tab' => 'photos'])
            ->with('success', 'Видимость фотографии изменена.');
    }
}
