<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_planner_cannot_access_user_management(): void
    {
        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_users_index(): void
    {
        $this->actingAsAdmin();

        $this->get(route('users.index'))
            ->assertOk()
            ->assertSee('Usuarios');
    }

    public function test_admin_can_create_user(): void
    {
        $this->actingAsAdmin();

        $this->post(route('users.store'), [
            'name' => 'Analista Institucional',
            'email' => 'analista@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_PLANNER,
            'status' => User::STATUS_ACTIVE,
        ])->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'analista@example.com',
            'role' => User::ROLE_PLANNER,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function test_admin_can_filter_users_by_status(): void
    {
        $this->actingAsAdmin();
        User::factory()->planner()->create([
            'name' => 'Usuario Activo',
            'status' => User::STATUS_ACTIVE,
        ]);
        User::factory()->planner()->inactive()->create([
            'name' => 'Usuario Inactivo',
        ]);

        $this->get(route('users.index', ['status' => User::STATUS_ACTIVE]))
            ->assertOk()
            ->assertSee('Usuario Activo')
            ->assertDontSee('Usuario Inactivo');
    }

    public function test_admin_can_update_user(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->planner()->create();

        $this->put(route('users.update', $user), [
            'name' => 'Administrador Funcional',
            'email' => 'admin.funcional@example.com',
            'password' => '',
            'password_confirmation' => '',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_INACTIVE,
        ])->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Administrador Funcional',
            'email' => 'admin.funcional@example.com',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_INACTIVE,
        ]);
    }

    public function test_admin_deactivates_user_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->planner()->create();

        $this->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => User::STATUS_INACTIVE,
        ]);
    }

    public function test_admin_cannot_deactivate_own_account_from_user_management(): void
    {
        $admin = $this->actingAsAdmin();

        $this->delete(route('users.destroy', $admin))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
