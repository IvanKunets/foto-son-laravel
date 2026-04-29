<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminGuestAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_root_to_admin_login(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('admin.login'));
    }

    public function test_guest_is_redirected_from_admin_orders_to_admin_login(): void
    {
        $this->get('/admin/orders')
            ->assertRedirect(route('admin.login'));
    }

    public function test_guest_is_redirected_from_admin_dashboard_to_admin_login(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect(route('admin.login'));
    }

    public function test_guest_can_access_public_services_page(): void
    {
        $this->get('/services')
            ->assertOk();
    }
}

