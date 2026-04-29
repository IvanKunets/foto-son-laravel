<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesAndOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_return_ok(): void
    {
        foreach (['/', '/services', '/gallery', '/reviews', '/contacts', '/privacy-policy'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_order_store_creates_order_when_valid(): void
    {
        $service = Service::query()->create([
            'title' => 'Тестовая услуга',
            'slug' => 'test-service-order',
            'description' => 'Описание',
            'price' => 1000,
            'is_visible' => true,
            'sort_order' => 1,
        ]);

        $tomorrow = now()->addDay()->format('Y-m-d');

        $response = $this->from('/contacts')->post('/order', [
            'client_name' => 'Иван Тестов',
            'client_phone' => '+7 (916) 390-55-65',
            'service_id' => (string) $service->id,
            'preferred_date' => $tomorrow,
            'preferred_time' => '14:30',
            'comment' => 'Комментарий к заявке',
            'agree' => '1',
        ]);

        $response->assertRedirect('/contacts');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'client_name' => 'Иван Тестов',
            'client_phone' => '+7 (916) 390-55-65',
            'service_id' => $service->id,
            'status' => 'new',
        ]);

        $order = Order::query()->first();
        $this->assertNotNull($order);
        $this->assertSame($tomorrow, $order->preferred_date?->format('Y-m-d'));
        $this->assertSame('14:30', $order->preferred_time);
    }

    public function test_order_store_redirects_back_with_errors_when_invalid(): void
    {
        $response = $this->from('/contacts')->post('/order', [
            'client_name' => '',
            'client_phone' => '123',
            'service_id' => '',
            'agree' => '',
        ]);

        $response->assertRedirect('/contacts');
        $response->assertSessionHasErrors(['client_name', 'client_phone', 'service_id', 'agree']);
        $this->assertDatabaseCount('orders', 0);
    }
}
