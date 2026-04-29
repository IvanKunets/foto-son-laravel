<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminServiceController extends Controller
{
    public function index(): View
    {
        // Категория подтягивается сразу — в таблице услуг не делаем дополнительный запрос на каждую строку
        $services = Service::query()
            ->with('category')
            ->orderBy('sort_order')
            ->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        $categories = ServiceCategory::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.services.create', compact('categories'));
    }

    public function store(AdminServiceRequest $request): RedirectResponse
    {
        Service::create([
            'title' => $request->validated('title'),
            'category_id' => $request->validated('category_id'),
            'slug' => $this->uniqueSlug($request->validated('title')),
            'description' => $request->validated('description'),
            'price' => $request->validated('price'),
            'image' => $request->file('image')->store('services', 'public'),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Услуга добавлена.');
    }

    public function edit(int $id): View
    {
        $service = Service::query()->findOrFail($id);
        $categories = ServiceCategory::query()
            ->where(function ($query) use ($service) {
                $query->where('is_visible', true);
                if ($service->category_id !== null) {
                    $query->orWhere('id', $service->category_id);
                }
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(AdminServiceRequest $request, int $id): RedirectResponse
    {
        $service = Service::query()->findOrFail($id);

        $payload = [
            'title' => $request->validated('title'),
            'category_id' => $request->validated('category_id'),
            'slug' => $this->uniqueSlug($request->validated('title'), $service->id),
            'description' => $request->validated('description'),
            'price' => $request->validated('price'),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->validated('sort_order'),
        ];

        if ($request->hasFile('image')) {
            if ($service->image && ! str_starts_with((string) $service->image, 'http')) {
                Storage::disk('public')->delete($service->image);
            }
            $payload['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($payload);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Услуга обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $service = Service::query()->findOrFail($id);

        if ($service->image && ! str_starts_with((string) $service->image, 'http')) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Услуга удалена.');
    }

    public function toggleVisible(int $id): RedirectResponse
    {
        $service = Service::query()->findOrFail($id);
        $service->update(['is_visible' => ! $service->is_visible]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Видимость услуги изменена.');
    }

    // Уникальный slug по заголовку — человекопонятный идентификатор без дубликатов в таблице services
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'service';
        }

        $slug = $base;
        $counter = 1;

        while (Service::query()
            ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
