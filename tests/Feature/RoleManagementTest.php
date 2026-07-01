<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        return $admin;
    }

    public function test_planner_cannot_access_role_management(): void
    {
        $planner = User::factory()->planner()->create();

        $this->actingAs($planner)
            ->get(route('roles.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_roles_index(): void
    {
        $this->actingAsAdmin();
        Role::factory()->create(['name' => 'Administrador funcional']);

        $this->get(route('roles.index'))
            ->assertOk()
            ->assertSee('Roles')
            ->assertSee('Administrador funcional');
    }

    public function test_admin_can_create_role_with_permissions(): void
    {
        $this->actingAsAdmin();
        $permission = Permission::factory()->create([
            'module' => 'usuarios',
            'action' => 'crear',
            'slug' => 'usuarios.crear',
        ]);

        $this->post(route('roles.store'), [
            'name' => 'Responsable institucional',
            'slug' => 'responsable-institucional',
            'description' => 'Gestiona informacion de una entidad.',
            'level' => 4,
            'is_active' => '1',
            'permissions' => [$permission->id],
        ])->assertRedirect(route('roles.index'));

        $role = Role::where('slug', 'responsable-institucional')->firstOrFail();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Responsable institucional',
            'level' => 4,
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('permission_role', [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_admin_can_update_role_and_permissions(): void
    {
        $this->actingAsAdmin();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'module' => 'roles',
            'action' => 'editar',
            'slug' => 'roles.editar',
        ]);

        $this->put(route('roles.update', $role), [
            'name' => 'Administrador de roles',
            'slug' => 'administrador-roles',
            'description' => 'Gestiona roles funcionales.',
            'level' => 8,
            'is_active' => '1',
            'permissions' => [$permission->id],
        ])->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Administrador de roles',
            'slug' => 'administrador-roles',
            'level' => 8,
        ]);
        $this->assertDatabaseHas('permission_role', [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_admin_deactivates_role_instead_of_deleting_it(): void
    {
        $this->actingAsAdmin();
        $role = Role::factory()->create(['is_active' => true]);

        $this->delete(route('roles.destroy', $role))
            ->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'is_active' => false,
        ]);
    }
}
