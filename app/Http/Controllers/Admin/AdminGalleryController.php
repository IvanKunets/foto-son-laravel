<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminGalleryController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'categories');

        // Два независимых paginator-а на одной странице: разные имена страниц и сохранение вкладки в query string
        $categories = GalleryCategory::query()
            ->orderBy('sort_order')
            ->paginate(15, ['*'], 'cat_page')
            ->appends(['tab' => 'categories']);

        $photos = GalleryPhoto::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate(15, ['*'], 'photo_page')
            ->appends(['tab' => 'photos']);

        return view('admin.gallery.index', compact('categories', 'photos', 'tab'));
    }
}
