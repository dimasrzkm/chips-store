<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Livewire\RolesPermissions\ApplyRoles;
use App\Livewire\RolesPermissions\EditApplyRoles;
use App\Livewire\RolesPermissions\ShowApplyRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplyRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_apply_roles_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat perizinan pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat perizinan pengguna');

        $user = User::factory()->create();
        $user->assignRole('pemilik');
        
        $response = $this->actingAs($user)
            ->get('role-and-permission/role/assign');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_see_form_apply_role_to_user()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah perizinan pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah perizinan pengguna');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertSee('Izinkan')
            ->assertOk();
        
        $response = $this->actingAs($user)->get('role-and-permission/role/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_apply_roles_to_user()
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
    public function pemilik_can_see_form_edit_role_to_user()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'merubah perizinan pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('merubah perizinan pengguna');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertSee('Sync')
            ->assertOk();
        
        $response = $this->actingAs($user)->get("role-and-permission/role/$user->username/edit");
        $response->assertOk();
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
    public function pemilik_can_empty_role_from_user()
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

    /** @test */
    public function pemilik_can_searh_data_role_from_user()
    {
        User::factory(3)->create();
         
        $this->assertCount(3, User::all());

        Livewire::withQueryParams(['search' => User::find(2)->name])
            ->test(ShowApplyRoles::class)
            ->assertSee(User::find(2)->name);
    }

    /** @test */
    public function user_with_role_other_than_pemilik_cannot_see_apply_role_to_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('role-and-permission/role/assign');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_apply_role_to_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertDontSee('Izinkan')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get('role-and-permission/role/create');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_update_role_to_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertDontSee('Sync')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get("role-and-permission/role/$user->username/edit");
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_empty_role_from_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('role-and-permission/role/assign');
        $response->assertDontSee('Hapus Peran');
        $response->assertSee(403);
    }
    
    /** @test */
    public function user_with_role_kasir_cannot_apply_role_to_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertDontSee('Izinkan')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get('role-and-permission/role/create');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_update_role_to_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('role-and-permission/role/assign')
            ->assertDontSee('Sync')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get("role-and-permission/role/$user->username/edit");
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_empty_role_to_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('role-and-permission/role/assign');
        $response->assertDontSee('Hapus Izin');
        $response->assertSee(403);
    }
}
