<?php

namespace Tests\Feature;

use App\Livewire\Roles\CreateRoles;
use App\Livewire\Roles\EditRoles;
use App\Livewire\Roles\ShowRoles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_roles_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        $response = $this->actingAs($user)
            ->get('roles');
        $response->assertOk();
    }

    /** @test */
    public function user_with_role_pemilik_can_see_form_create_permissions()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        $response = $this->actingAs($user)->get('roles/create');
        $response->assertOk();
    }

    /** @test */
    public function user_can_add_role_data()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateRoles::class)
            ->set('form.name', 'pemilik')
            ->set('form.guardName', 'web')
            ->call('createRole')
            ->assertRedirect('roles');

        $this->assertCount(1, Role::all());
    }

    /** @test */
    public function user_can_edit_role_data()
    {
        $user = User::factory()->create();

        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $this->assertCount(1, Role::all());

        Livewire::actingAs($user)
            ->test(EditRoles::class, ['role' => $role])
            ->set('form.name', 'pemiliks')
            ->set('form.guardName', $role->guard_name)
            ->call('editRole')
            ->assertRedirect('roles');

        $this->assertEquals('pemiliks', Role::first()->name);
    }

    /** @test */
    public function user_can_delete_role_data()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $this->assertCount(1, Role::all());

        Livewire::actingAs($user)
            ->test(ShowRoles::class)
            ->call('getDataForDelete', $role)
            ->call('deleteRole')
            ->assertRedirect('roles');

        $this->assertCount(0, Role::all());
    }
}
