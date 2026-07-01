<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_assigns_planner_role(): void
    {
        $this->post(route('register'), [
            'name' => 'Planificador Demo',
            'email' => 'planificador@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'planificador@example.com',
            'role' => User::ROLE_PLANNER,
        ]);
    }

    public function test_admin_middleware_blocks_planner_users(): void
    {
        $this->registerAdminOnlyRoute();

        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get('/testing/admin-only')
            ->assertForbidden();
    }

    public function test_admin_middleware_allows_admin_users(): void
    {
        $this->registerAdminOnlyRoute();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/testing/admin-only')
            ->assertOk()
            ->assertSee('ok');
    }

    public function test_super_admin_is_treated_as_admin(): void
    {
        $this->registerAdminOnlyRoute();

        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)
            ->get('/testing/admin-only')
            ->assertOk()
            ->assertSee('ok');
    }

    private function registerAdminOnlyRoute(): void
    {
        Route::middleware(['web', 'auth', 'admin'])->get('/testing/admin-only', fn () => 'ok');
    }
}
