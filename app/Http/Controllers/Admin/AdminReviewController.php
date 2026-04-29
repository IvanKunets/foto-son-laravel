<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminReviewRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminReviewController extends Controller
{
    public function index(): View
    {
        // Пагинация вместо get(): полный список отзывов в админке не подгружается целиком
        $reviews = Review::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create(): View
    {
        return view('admin.reviews.create');
    }

    public function store(AdminReviewRequest $request): RedirectResponse
    {
        $reviewedAt = $request->validated('reviewed_at');

        $data = [
            'author_name' => $request->validated('author_name'),
            'rating' => $request->validated('rating'),
            'content' => $request->validated('text'),
            'is_visible' => $request->boolean('is_visible'),
            'service_name' => $request->validated('service_name'),
            'reviewed_at' => $reviewedAt ?: now()->toDateString(),
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('reviews/avatars', 'public');
        }

        Review::create($data);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Отзыв добавлен.');
    }

    public function edit(int $id): View
    {
        $review = Review::query()->findOrFail($id);

        return view('admin.reviews.edit', compact('review'));
    }

    public function update(AdminReviewRequest $request, int $id): RedirectResponse
    {
        $review = Review::query()->findOrFail($id);

        $reviewedAt = $request->validated('reviewed_at');

        $payload = [
            'author_name' => $request->validated('author_name'),
            'rating' => $request->validated('rating'),
            'content' => $request->validated('text'),
            'is_visible' => $request->boolean('is_visible'),
            'service_name' => $request->validated('service_name'),
            'reviewed_at' => $reviewedAt,
        ];

        if ($request->hasFile('avatar')) {
            if ($review->avatar && Storage::disk('public')->exists($review->avatar)) {
                Storage::disk('public')->delete($review->avatar);
            }
            $payload['avatar'] = $request->file('avatar')->store('reviews/avatars', 'public');
        }

        $review->update($payload);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Отзыв обновлён.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $review = Review::query()->findOrFail($id);
        if ($review->avatar && Storage::disk('public')->exists($review->avatar)) {
            Storage::disk('public')->delete($review->avatar);
        }
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Отзыв удалён.');
    }

    public function toggleVisible(int $id): RedirectResponse
    {
        $review = Review::query()->findOrFail($id);
        $review->update(['is_visible' => ! $review->is_visible]);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Видимость отзыва изменена.');
    }
}
