<?php

namespace Tests\Feature;

use App\Livewire\Users\CreateUsers;
use App\Livewire\Users\EditUsers;
use App\Livewire\Users\ShowUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_users_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat pengguna');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('users');
        $response->assertOk();
        $response->assertSee('Pengguna');
    }

    /** @test */
    public function pemilik_can_see_form_create_user()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah pengguna');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->actingAs($pemilik)
            ->get('users')
            ->assertSee('Tambah Pengguna');

        $response = $this->actingAs($pemilik)->get('users/create');
        $response->assertOk();
        $response->assertSee('Tambah Pengguna');
    }

    /** @test */
    public function pemilik_can_add_another_user_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->assertCount(1, User::all());

        Livewire::actingAs($pemilik)
            ->test(CreateUsers::class)
            ->set('form.name', 'salma')
            ->set('form.email', 'salma@gmail.com')
            ->set('form.username', 'salma.andini')
            ->set('form.password', 'password')
            ->set('form.address', 'dummy')
            ->set('form.telephone_number', '081299901234')
            ->call('submit')
            ->assertRedirect('users');

        $this->assertCount(2, User::all());
    }

    /** @test */
    public function pemilik_can_see_form_edit_user()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah pengguna');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateUsers::class)
            ->set('form.name', 'salma')
            ->set('form.email', 'salma@gmail.com')
            ->set('form.username', 'salma.andini')
            ->set('form.password', 'password')
            ->set('form.address', 'dummy')
            ->set('form.telephone_number', '081299901234')
            ->call('submit')
            ->assertRedirect('users');

        $this->assertCount(2, User::all());

        $this->actingAs($pemilik)
            ->get('users')
            ->assertSee('Edit');

        $dataUser = User::find(2);

        $response = $this->actingAs($pemilik)->get("users/$dataUser->username/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_update_another_user_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->assertCount(1, User::all());

        Livewire::actingAs($pemilik)
            ->test(CreateUsers::class)
            ->set('form.name', 'salma')
            ->set('form.email', 'salma@gmail.com')
            ->set('form.username', 'salma.andini')
            ->set('form.password', 'password')
            ->set('form.address', 'dummy')
            ->set('form.telephone_number', '081299901234')
            ->call('submit')
            ->assertRedirect('users');

        $this->assertCount(2, User::all());

        $dataPenggunaKeDua = User::find(2);

        Livewire::actingAs($pemilik)
            ->test(EditUsers::class, ['user' => $dataPenggunaKeDua])
            ->set('form.name', 'salma nih')
            ->call('submit')
            ->assertRedirect('users');

        $this->assertEquals('salma nih', User::find(2)->name);
    }

    /** @test */
    public function pemilik_can_see_hapus_button_to_delete_data_user()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus pengguna', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus pengguna');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $response = $this->actingAs($pemilik)->get('users');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Pengguna!');
    }

    /** @test */
    public function pemilik_can_delete_another_user_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->assertCount(1, User::all());

        Livewire::actingAs($pemilik)
            ->test(CreateUsers::class)
            ->set('form.name', 'salma')
            ->set('form.email', 'salma@gmail.com')
            ->set('form.username', 'salma.andini')
            ->set('form.password', 'password')
            ->set('form.address', 'dummy')
            ->set('form.telephone_number', '081299901234')
            ->call('submit')
            ->assertRedirect('users');

        $this->assertCount(2, User::all());

        $dataPenggunaKeDua = User::find(2);

        Livewire::actingAs($pemilik)
            ->test(ShowUsers::class)
            ->call('getDataForDelete', $dataPenggunaKeDua)
            ->call('deleteUser')
            ->assertRedirect('users');

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function pemilik_can_search_data_users()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        User::factory()->create(['name' => 'testing']);
        User::factory(5)->create();

        $this->assertCount(6, User::all());

        Livewire::withQueryParams(['search' => 'testing'])
            ->test(ShowUsers::class)
            ->assertSee('testing');
    }

    /** @test */
    public function user_with_role_other_than_pemilik_cannot_see_user_page()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');
        $response = $this->actingAs($user)->get('users');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_add_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('users')
            ->assertDontSee('Tambah Pengguna')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('users/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_edit_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $anotherUser = User::factory()->create();

        $this->actingAs($user)
            ->get('users')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("users/$anotherUser->username/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_canot_delete_user()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('users');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Pengguna!');
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_add_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('users')
            ->assertDontSee('Tambah Pengguna')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('users/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_edit_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $anotherUser = User::factory()->create();

        $this->actingAs($user)
            ->get('users')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("users/$anotherUser->username/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_canot_delete_user()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('users');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Pengguna!');
    }
}
