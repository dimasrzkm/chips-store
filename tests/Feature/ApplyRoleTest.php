<?php

namespace Tests\Feature;

use App\Livewire\RolesPermissions\ApplyRoles;
use App\Livewire\RolesPermissions\EditApplyRoles;
use App\Livewire\RolesPermissions\ShowApplyRoles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApplyRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_apply_role()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('role-and-permission/role/assign');
        $response->assertOk();
    }

    /** @test */
    public function user_can_apply_role_to_user()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(ApplyRoles::class)
            ->set('form.user_id', $user->id)
            ->set('form.roles', [$role])
            ->call('submit')
            ->assertRedirect('role-and-permission/role/assign');

        $this->assertTrue($user->hasRole('pemilik'));
    }

    /** @test */
    public function user_can_update_roles_to_user()
    {
        $user = User::factory()->create();
        $role1 = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(ApplyRoles::class)
            ->set('form.user_id', $user->id)
            ->set('form.roles', [$role1])
            ->call('submit');

        $this->assertTrue($user->hasRole('pemilik'));

        Livewire::actingAs($user)
            ->test(EditApplyRoles::class, ['user' => $user])
            ->set('form.user_id', $user->id)
            ->set('form.roles', [$role2])
            ->call('submit');

        $this->assertTrue($user->hasRole('pemilik'));
    }

    /** @test */
    public function user_has_pemilik_privilege_can_revoke_all_role_from_user()
    {
        $user1 = User::factory()->create(['email' => 'test1@gmail.com']);
        $user2 = User::factory()->create(['email' => 'test2@gmail.com']);
        $role1 = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        Livewire::actingAs($user1)
            ->test(ApplyRoles::class)
            ->set('form.user_id', $user1->id)
            ->set('form.roles', [$role1])
            ->call('submit');

        Livewire::actingAs($user1)
            ->test(ApplyRoles::class)
            ->set('form.user_id', $user2->id)
            ->set('form.roles', [$role2])
            ->call('submit');

        Livewire::actingAs($user1)
            ->test(ShowApplyRoles::class)
            ->call('revokeRole', $user2);

        $this->assertEquals(0, User::find($user2->id)->roles->count());
    }
}
