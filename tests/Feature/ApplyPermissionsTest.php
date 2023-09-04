<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\RolesPermissions\ApplyPermissions;
use App\Livewire\RolesPermissions\ShowApplyPermission;
use App\Livewire\RolesPermissions\EditApplyPermissions;

class ApplyPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_apply_permissions_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat perizinan peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat perizinan peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');
        
        $response = $this->actingAs($user)->get('role-and-permission/permission/assignable');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_see_form_apply_permissions_to_role()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah perizinan peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah perizinan peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertSee('Izinkan')
            ->assertOk();
        
        $response = $this->actingAs($user)->get('role-and-permission/permission/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_apply_permissions_to_role()
    {
        $permission1 = Permission::create(['name' => 'melihat data izin', 'guard_name' => 'web']);
        $permission2 = Permission::create(['name' => 'menambah data izin', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        
        $this->assertCount(2, Permission::all());
        $this->assertCount(1, Role::all());
        
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        
        Livewire::actingAs($user)
            ->test(ApplyPermissions::class)
            ->set('form.role_id', $role->id)
            ->set('form.permissions', [$permission1, $permission2])
            ->call('submit');

        $this->assertCount(2, Role::first()->getAllPermissions());
    }

    /** @test */
    public function pemilik_can_see_form_update_permissions_to_role()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah perizinan peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah perizinan peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertSee('Sync')
            ->assertOk();

        $response = $this->actingAs($user)->get("role-and-permission/permission/$role->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_update_permissions_to_role()
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

    /** @test */
    public function pemilik_can_empty_permissions_from_role()
    {
        $permission1 = Permission::create(['name' => 'melihat data izin', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        
        $this->assertCount(1, Permission::all());
        $this->assertCount(1, Role::all());
        
        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Livewire::actingAs($user)
            ->test(ApplyPermissions::class)
            ->set('form.role_id', $role->id)
            ->set('form.permissions', [$permission1])
            ->call('submit');
        
        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertSee('Hapus Izin')
            ->assertOk();

        Livewire::actingAs($user)
            ->test(ShowApplyPermission::class)
            ->call('revokePermission', $role);
            
        $this->assertCount(0, $role->getPermissionNames());
    }

    /** @test */
    public function pemilik_can_searh_data_permissions_from_role()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
         Role::create(['name' => 'kasir', 'guard_name' => 'web']);
         Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
         
         $this->assertCount(3, Role::all());
 
         Livewire::withQueryParams(['search' => 'bagian gudang'])
             ->test(ShowApplyPermission::class)
             ->assertSee('bagian gudang');
    }

    /** @test */
    public function user_with_role_other_than_pemilik_cannot_see_apply_permissions_to_role()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('role-and-permission/permission/assignable');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_apply_permissions_to_role()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertDontSee('Izinkan')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get('role-and-permission/permission/create');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_update_permissions_to_role()
    {
        $role = Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertDontSee('Sync')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get("role-and-permission/permission/$role->name/edit");
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_empty_permissions_from_role()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('role-and-permission/permission/assignable');
        $response->assertDontSee('Hapus Izin');
        $response->assertSee(403);
    }
    
    /** @test */
    public function user_with_role_kasir_cannot_apply_permissions_to_role()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertDontSee('Izinkan')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get('role-and-permission/permission/create');
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_update_permissions_to_role()
    {
        $role = Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('role-and-permission/permission/assignable')
            ->assertDontSee('Sync')
            ->assertStatus(403);
        
        $response = $this->actingAs($user)->get("role-and-permission/permission/$role->name/edit");
        $response->assertSee(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_empty_permissions_from_role()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('role-and-permission/permission/assignable');
        $response->assertDontSee('Hapus Izin');
        $response->assertSee(403);
    }

}
