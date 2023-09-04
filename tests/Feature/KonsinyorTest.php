<?php

namespace Tests\Feature;

use App\Livewire\Konsinyors\CreateKonsinyors;
use App\Livewire\Konsinyors\EditKonsinyors;
use App\Livewire\Konsinyors\ShowKonsinyors;
use App\Models\Konsinyor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KonsinyorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_konsinyor_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat konsinyor', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat konsinyor');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');
        
        $response = $this->actingAs($pemilik)->get('konsinyors');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_see_form_create_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah konsinyor', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah konsinyor');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->actingAs($pemilik)
            ->get('konsinyors')
            ->assertSee('Tambah Konsinyor');
        
        $response = $this->actingAs($pemilik)->get('konsinyors/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_add_data_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $response = $this->actingAs($pemilik)->get('konsinyors/create');
        $response->assertOk();

        Livewire::actingAs($pemilik)
            ->test(CreateKonsinyors::class)
            ->set('form.name', 'ali')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089512349087')
            ->call('submit')
            ->assertRedirect('konsinyors');

        $this->assertCount(1, Konsinyor::all());
    }

    /** @test */
    public function pemilik_can_see_form_edit_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah konsinyor', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah konsinyor');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');
        
        Livewire::actingAs($pemilik)
            ->test(CreateKonsinyors::class)
            ->set('form.name', 'ali')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089512349087')
            ->call('submit')
            ->assertRedirect('konsinyors');

        $dataKonsinyor = Konsinyor::find(1);

        $this->actingAs($pemilik)
            ->get('konsinyors')
            ->assertSee('Edit');

        $response = $this->actingAs($pemilik)->get("konsinyors/$dataKonsinyor->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_edit_data_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateKonsinyors::class)
            ->set('form.name', 'ali')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089512349087')
            ->call('submit')
            ->assertRedirect('konsinyors');

        $this->assertCount(1, Konsinyor::all());

        $dataKonsinyor = Konsinyor::find(1);

        $response = $this->actingAs($pemilik)->get("konsinyors/$dataKonsinyor->name/edit");
        $response->assertOk();

        Livewire::actingAs($pemilik)
            ->test(EditKonsinyors::class, ['konsinyor' => $dataKonsinyor])
            ->set('form.name', 'ali -edited')
            ->set('form.address', 'yahh')
            ->set('form.telephone_number', '089512689087')
            ->call('submit')
            ->assertRedirect('konsinyors');

        $this->assertEquals('ali -edited', Konsinyor::first()->name);
    }

    /** @test */
    public function pemilik_can_see_hapus_button_to_delete_data_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus konsinyor', 
        'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus konsinyor');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $response = $this->actingAs($pemilik)->get('konsinyors');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Konsinyor!');
    }

    /** @test */
    public function pemilik_can_delete_data_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateKonsinyors::class)
            ->set('form.name', 'ali')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089512349087')
            ->call('submit')
            ->assertRedirect('konsinyors');

        $this->assertCount(1, Konsinyor::all());

        $dataKonsinyor = Konsinyor::find(1);

        Livewire::actingAs($pemilik)
            ->test(ShowKonsinyors::class)
            ->call('getDataForDelete', $dataKonsinyor)
            ->call('deleteKonsinyor')
            ->assertRedirect('konsinyors');

        $this->assertCount(0, Konsinyor::all());
    }

    /** @test */
    public function pemilik_can_search_data_konsinyor()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Konsinyor::factory(15)->create();

        $this->assertCount(15, Konsinyor::all());

        Livewire::withQueryParams(['search' => Konsinyor::find(1)->name])
            ->test(ShowKonsinyors::class)
            ->assertSee(Konsinyor::find(1)->name);
    }

    /** @test */
    public function user_with_role_bagian_gudang_can_see_the_konsinyor_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat konsinyor', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat konsinyor');
        
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');
        
        $response = $this->actingAs($user)->get('konsinyors');
        $response->assertOk();
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_add_konsinyor()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('konsinyors')
            ->assertDontSee('Tambah Konsinyor')
            ->assertStatus(200);

        $response = $this->actingAs($user)->get('konsinyors/create');
        $response->assertDontSee('Tambah Konsinyor');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_edit_konsinyor()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');
        
        $this->actingAs($user)
            ->get('konsinyors')
            ->assertDontSee('Edit')
            ->assertOk();

        $response = $this->actingAs($user)->get("konsinyors/$user->name/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_bagian_gudang_cannot_delete_konsinyor()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('konsinyors');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Konsinyor!');
    }

    /** @test */
    public function user_with_role_other_than_pemilik_and_bagian_gudang_cannot_see_the_konsinyor_page()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');
        $response = $this->actingAs($user)->get('konsinyors');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_add_konsinyor()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('konsinyors')
            ->assertDontSee('Tambah Konsinyor')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('konsinyors/create');
        $response->assertDontSee('Tambah Konsinyor');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_edit_konsinyor()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('konsinyors')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("konsinyors/$user->name/edit");
        $response->assertDontSee('Edit');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_delete_konsinyor()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('konsinyors');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Konsinyor!');
    }
}
