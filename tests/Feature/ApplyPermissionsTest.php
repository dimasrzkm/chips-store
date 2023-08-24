<?php

namespace Tests\Feature;

use App\Livewire\RolesPermissions\ApplyPermissions;
use App\Livewire\RolesPermissions\EditApplyPermissions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApplyPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_apply_permissions()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        $response = $this->actingAs($user)
            ->get('role-and-permission/permission/assignable');
        $response->assertOk();
    }

    /** @test */
    public function user_can_apply_permissions_to_role()
    {
        $user = User::factory()->create();
        $permission1 = Permission::create(['name' => 'melihat data izin', 'guard_name' => 'web']);
        $permission2 = Permission::create(['name' => 'menambah data izin', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $this->assertCount(1, User::all());
        $this->assertCount(2, Permission::all());
        $this->assertCount(1, Role::all());

        Livewire::actingAs($user)
            ->test(ApplyPermissions::class)
            ->set('form.role_id', $role->id)
            ->set('form.permissions', [$permission1, $permission2])
            ->call('submit');

        $this->assertCount(2, Role::first()->getAllPermissions());
    }

    /** @test */
    public function user_can_update_permissions_to_role()
    {
        $user = User::factory()->create();
        $permission1 = Permission::create(['name' => 'melihat data izin', 'guard_name' => 'web']);
        $permission2 = Permission::create(['name' => 'menambah data izin', 'guard_name' => 'web']);
        $permission3 = Permission::create(['name' => 'mengubah data izin', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $this->assertCount(1, User::all());
        $this->assertCount(3, Permission::all());
        $this->assertCount(1, Role::all());

        Livewire::actingAs($user)
            ->test(ApplyPermissions::class)
            ->set('form.role_id', $role->id)
            ->set('form.permissions', [$permission1, $permission2])
            ->call('submit');

        Livewire::actingAs($user)
            ->test(EditApplyPermissions::class, ['role' => $role->name])
            ->set('form.role_id', $role->id)
            ->set('form.permissions', [$permission1, $permission3])
            ->call('submit');

        $this->assertCount(2, Role::first()->getAllPermissions());
        $this->assertEquals('melihat data izin', $role->permissions->pluck('name')[0]);
        $this->assertEquals('mengubah data izin', $role->permissions->pluck('name')[1]);
    }
}
