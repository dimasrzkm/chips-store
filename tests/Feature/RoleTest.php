<?php

namespace Tests\Feature;

use App\Livewire\Roles\CreateRoles;
use App\Livewire\Roles\EditRoles;
use App\Livewire\Roles\ShowRoles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_roles_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('roles');
        $response->assertOk();
        $response->assertSee('Peran');
    }

    /** @test */
    public function pemilik_can_see_form_create_role()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('roles')
            ->assertSee('Tambah Peran');

        $response = $this->actingAs($user)->get('roles/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_add_role_data()
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
    public function pemilik_can_see_form_edit_role()
    {
        $role = Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('roles')
            ->assertSee('Edit');

        $response = $this->actingAs($user)->get("roles/$role->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_edit_role_data()
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
    public function pemilik_can_see_button_hapus_to_delete_data_role()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus peran', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus peran');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('roles');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Peran!');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_delete_role_data()
    {
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

    /** @test */
    public function pemilik_can_search_data_roles()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $this->assertCount(3, Role::all());

        Livewire::withQueryParams(['search' => 'kasir'])
            ->test(ShowRoles::class)
            ->assertSee('kasir');
    }

    /** @test */
    public function user_with_role_other_than_pemilik_cannot_see_roles_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');
        $response = $this->actingAs($user)->get('roles');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_add_role()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('roles')
            ->assertDontSee('Tambah Peran')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('roles/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_edit_role()
    {
        $role = Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('roles')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("roles/$role->name/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_delete_role()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('roles');
        $response->assertDontSee('Delete');
        $response->assertDontSee('Menghapus Data Peran!');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_kasir_cannot_add_role()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('roles')
            ->assertDontSee('Tambah Peran')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('roles/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_edit_role()
    {
        $role = Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('roles')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("roles/$role->name/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_delete_role()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('roles');
        $response->assertDontSee('Delete');
        $response->assertDontSee('Menghapus Data Peran!');
        $response->assertStatus(403);
    }
}
