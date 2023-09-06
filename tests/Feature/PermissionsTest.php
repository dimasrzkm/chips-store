<?php

namespace Tests\Feature;

use App\Livewire\Permissions\CreatePermissions;
use App\Livewire\Permissions\EditPermissions;
use App\Livewire\Permissions\ShowPermissions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_permissions_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat izin');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('permissions');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_see_form_create_permissions()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah izin', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah izin');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('permissions')
            ->assertSee('Tambah Izin');

        $response = $this->actingAs($user)->get('permissions/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_add_permission_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Livewire::actingAs($user)
            ->test(CreatePermissions::class)
            ->set('form.name', 'melihat izin')
            ->set('form.guard_name', 'web')
            ->call('createPermission')
            ->assertRedirect('permissions');

        $this->assertCount(1, Permission::all());
    }

    /** @test */
    public function pemilik_can_see_form_edit_permission()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'mengubah izin', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah izin');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('permissions')
            ->assertSee('Edit');

        $response = $this->actingAs($user)->get("permissions/$permission->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_edit_permission_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->assertCount(1, Permission::all());

        Livewire::actingAs($user)
            ->test(EditPermissions::class, ['permission' => $permission])
            ->set('form.name', 'melihat izin itu')
            ->set('form.guard_name', $permission->guard_name)
            ->call('editPermission')
            ->assertRedirect('permissions');

        $this->assertCount(1, Permission::all());
        $this->assertEquals('melihat izin itu', Permission::first()->name);
    }

    /** @test */
    public function pemilik_can_see_hapus_buton_to_delete_permissions_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus izin', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus izin');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('permissions')
            ->assertSee('Hapus')
            ->assertSee('Menghapus Data Izin!');
    }

    /** @test */
    public function pemilik_can_delete_permission_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->assertCount(1, Permission::all());

        Livewire::actingAs($user)
            ->test(ShowPermissions::class)
            ->call('getIdForDelete', $permission)
            ->call('deletePermission', $permission)
            ->assertRedirect('permissions');

        $this->assertCount(0, Permission::all());
    }

    /** @test */
    public function pemilik_can_search_data_permissions()
    {
        Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat peran', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah peran', 'guard_name' => 'web']);

        $this->assertCount(3, Permission::all());

        Livewire::withQueryParams(['search' => 'menambah peran'])
            ->test(ShowPermissions::class)
            ->assertSee('menambah peran');
    }

    /** @test */
    public function user_with_role_other_than_pemilik_cannot_see_permissions_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');
        $response = $this->actingAs($user)->get('permissions');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_add_permission()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('permissions')
            ->assertDontSee('Tambah Izin')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('permissions/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_edit_permission()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $permission = Role::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('permissions')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("permissions/$permission->name/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_delete_permission()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('permissions');
        $response->assertDontSee('Delete');
        $response->assertDontSee('Menghapus Data Izin!');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_kasir_cannot_add_permission()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('permissions')
            ->assertDontSee('Tambah Izin')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('permissions/create');
        $response->assertDontSee('Tambah Izin');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_edit_permission()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $permission = Role::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('permissions')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("permissions/$permission->name/edit");
        $response->assertDontSee('Ubah');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_delete_permission()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('permissions');
        $response->assertDontSee('Delete');
        $response->assertDontSee('Menghapus Data Izin!');
        $response->assertStatus(403);
    }
}
