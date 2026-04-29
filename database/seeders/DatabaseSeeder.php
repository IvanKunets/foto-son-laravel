<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // На production демо-сидинг отключён по умолчанию: чтобы не создать тестовый админ-аккаунт и учебные данные.
        // Явное включение возможно только через ALLOW_DEMO_SEED=true в окружении.
        if (app()->environment('production') && ! filter_var(env('ALLOW_DEMO_SEED', false), FILTER_VALIDATE_BOOL)) {
            $this->command?->warn('DatabaseSeeder: demo seed пропущен в production (ALLOW_DEMO_SEED=false).');

            return;
        }

        // Пароль для локальной/dev-разработки; в production задайте свой (см. docs/ADMIN_PASSWORD_POLICY.md).
        // Строка ниже соответствует базовой политике Password::defaults() в AppServiceProvider (≥10 символов, регистр, цифры).
        User::query()->updateOrCreate(
            ['email' => 'admin@foto-son.ru'],
            [
                'name' => 'Администратор',
                'password' => 'FotoSon2026!Demo',
            ]
        );

        $serviceCategoriesData = [
            ['name' => 'Фотосъёмка', 'slug' => 'photoshoot', 'sort_order' => 1],
            ['name' => 'Печать и сувениры', 'slug' => 'print-and-gifts', 'sort_order' => 2],
            ['name' => 'Офисные услуги', 'slug' => 'office-services', 'sort_order' => 3],
            ['name' => 'Обработка', 'slug' => 'retouch', 'sort_order' => 4],
            ['name' => 'Онлайн-услуги', 'slug' => 'online-services', 'sort_order' => 5],
        ];

        $serviceCategories = [];
        foreach ($serviceCategoriesData as $category) {
            $serviceCategories[$category['slug']] = ServiceCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'is_visible' => true,
                    'sort_order' => $category['sort_order'],
                ]
            );
        }

        $servicesData = [
            ['title' => 'Портретная съемка', 'price' => 300.00, 'category' => 'photoshoot'],
            ['title' => 'Детские фотосессии', 'price' => 2500.00, 'category' => 'photoshoot'],
            ['title' => 'Семейные фотосессии', 'price' => 4500.00, 'category' => 'photoshoot'],
            ['title' => 'Свадебная съемка', 'price' => 15000.00, 'category' => 'photoshoot'],
            ['title' => 'Фотосессия для документов', 'price' => 500.00, 'category' => 'office-services'],
            ['title' => 'Печать фотографий', 'price' => 25.00, 'category' => 'print-and-gifts'],
        ];

        $services = [];
        foreach ($servicesData as $index => $service) {
            $services[] = Service::create([
                'title' => $service['title'],
                'category_id' => $serviceCategories[$service['category']]->id ?? null,
                'slug' => Str::slug($service['title']),
                'description' => 'Тестовое описание услуги: ' . $service['title'],
                'price' => $service['price'],
                'image' => 'storage/services/service' . ($index + 1) . '.jpg',
                'is_visible' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $categoriesData = [
            'Портрет',
            'Семья',
            'Дети',
            'Свадьбы',
            'Документы',
        ];

        foreach ($categoriesData as $categoryIndex => $categoryName) {
            $category = GalleryCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'is_visible' => true,
                'sort_order' => $categoryIndex + 1,
            ]);

            $prefix = Str::slug($categoryName);
            $photosCount = $categoryIndex % 2 === 0 ? 4 : 3;

            for ($i = 1; $i <= $photosCount; $i++) {
                GalleryPhoto::create([
                    'category_id' => $category->id,
                    'image' => 'images/gallery/' . $prefix . $i . '.jpg',
                    'alt' => $categoryName . ' фото ' . $i,
                    'is_visible' => true,
                    'sort_order' => $i,
                ]);
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            Review::create([
                'author_name' => 'Клиент ' . $i,
                'content' => 'Отличная работа! Тестовый отзыв #' . $i,
                'rating' => random_int(4, 5),
                'is_visible' => true,
                'service_name' => ['Семейная фотосессия', 'Портрет', 'Love story', 'Выпускной'][$i % 4],
                'reviewed_at' => now()->subDays($i)->toDateString(),
            ]);
        }

        $ordersData = [
            ['status' => 'new', 'service_index' => 0, 'client_name' => 'Иван Иванов'],
            ['status' => 'in_progress', 'service_index' => 2, 'client_name' => 'Мария Петрова'],
            ['status' => 'done', 'service_index' => 3, 'client_name' => 'Алексей Смирнов'],
        ];

        foreach ($ordersData as $orderIndex => $order) {
            Order::create([
                'client_name' => $order['client_name'],
                'client_phone' => '+7 (900) 000-00-0' . ($orderIndex + 1),
                'service_id' => $services[$order['service_index']]->id ?? null,
                'preferred_date' => now()->addDays(($orderIndex + 1) * 3)->toDateString(),
                'comment' => 'Тестовая заявка #' . ($orderIndex + 1),
                'status' => $order['status'],
            ]);
        }
    }
}
