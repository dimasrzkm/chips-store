<?php

namespace Tests\Feature;

use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ShowSuppliers;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_bagian_gudang_can_see_the_supplier_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat supplier');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('suppliers');
        $response->assertOk();
        $response->assertSee('Suppliers');
    }

    /** @test */
    public function bagian_gudang_can_see_form_create_suplier()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah supplier');

        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        $this->actingAs($bagian_gudang)
            ->get('suppliers')
            ->assertSee('Tambah Supplier');

        $response = $this->actingAs($bagian_gudang)->get('suppliers/create');
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_add_supplier_data()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        Livewire::actingAs($bagian_gudang)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());
    }

    /** @test */
    public function bagian_gudang_can_see_form_edit_supplier()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah supplier');

        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        Livewire::actingAs($bagian_gudang)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        $this->actingAs($bagian_gudang)
            ->get('suppliers')
            ->assertSee('Edit');

        $dataSupplier = Supplier::find(1);

        $response = $this->actingAs($bagian_gudang)->get("suppliers/$dataSupplier->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_edit_supplier_data()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        Livewire::actingAs($bagian_gudang)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        $supplier = Supplier::find(1);

        Livewire::actingAs($bagian_gudang)
            ->test(EditSupplier::class, ['supplier' => $supplier])
            ->set('form.name', 'alif rahman')
            ->set('form.address', 'jln dummy no 03')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertEquals('alif rahman', Supplier::find(1)->name);
        $this->assertEquals('jln dummy no 03', Supplier::find(1)->address);
    }

    /** @test */
    public function bagian_gudang_can_see_hapus_button_to_delete_data_supplier()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus supplier');

        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        $response = $this->actingAs($bagian_gudang)->get('suppliers');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Supplier!');
    }

    /** @test */
    public function bagian_gudang_can_delete_supplier_data()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('bagian gudang');

        Livewire::actingAs($bagian_gudang)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        Livewire::actingAs($bagian_gudang)
            ->test(ShowSuppliers::class)
            ->call('getDataForDelete', Supplier::find(1))
            ->call('deleteSupplier');

        $this->assertCount(0, Supplier::all());
    }

    /** @test */
    public function bagian_gudang_can_search_data_suppliers()
    {
        Supplier::factory(6)->create();

        $this->assertCount(6, Supplier::all());

        Livewire::withQueryParams(['search' => Supplier::find(1)->name])
            ->test(ShowSuppliers::class)
            ->assertSee(Supplier::find(1)->name);
    }

    /** @test */
    public function user_with_role_pemilik_can_see_the_supplier_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat supplier');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('suppliers');
        $response->assertOk();
        $response->assertSee('Suppliers');
    }

    /** @test */
    public function pemilik_can_see_form_create_suplier()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah supplier');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        $this->actingAs($pemilik)
            ->get('suppliers')
            ->assertSee('Tambah Supplier');

        $response = $this->actingAs($pemilik)->get('suppliers/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_add_supplier_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());
    }

    /** @test */
    public function pemilik_can_see_form_edit_supplier()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah supplier');

        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        $this->actingAs($pemilik)
            ->get('suppliers')
            ->assertSee('Edit');

        $dataSupplier = Supplier::find(1);

        $response = $this->actingAs($pemilik)->get("suppliers/$dataSupplier->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_edit_supplier_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        $supplier = Supplier::find(1);

        Livewire::actingAs($pemilik)
            ->test(EditSupplier::class, ['supplier' => $supplier])
            ->set('form.name', 'alif rahman')
            ->set('form.address', 'jln dummy no 03')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertEquals('alif rahman', Supplier::find(1)->name);
        $this->assertEquals('jln dummy no 03', Supplier::find(1)->address);
    }

    /** @test */
    public function pemilik_can_see_hapus_button_to_delete_data_supplier()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus supplier', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus supplier');

        $bagian_gudang = User::factory()->create();
        $bagian_gudang->assignRole('pemilik');

        $response = $this->actingAs($bagian_gudang)->get('suppliers');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Supplier');
    }

    /** @test */
    public function pemilik_can_delete_supplier_data()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $pemilik = User::factory()->create();
        $pemilik->assignRole('pemilik');

        Livewire::actingAs($pemilik)
            ->test(CreateSupplier::class)
            ->set('form.name', 'alif')
            ->set('form.address', 'jln dummy')
            ->set('form.telephone_number', '089912349087')
            ->call('submit')
            ->assertRedirect('suppliers');

        $this->assertCount(1, Supplier::all());

        Livewire::actingAs($pemilik)
            ->test(ShowSuppliers::class)
            ->call('getDataForDelete', Supplier::find(1))
            ->call('deleteSupplier');

        $this->assertCount(0, Supplier::all());
    }

    /** @test */
    public function user_with_role_other_than_bagian_gudang_and_pemilik_cannot_see_supplier_page()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');
        $response = $this->actingAs($user)->get('suppliers');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_add_supplier()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('suppliers')
            ->assertDontSee('Tambah Supplier')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('suppliers/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_edit_supplier()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('suppliers')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get("suppliers/$user->name/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_role_kasir_cannot_delete_data_supplier()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        $kasir = User::factory()->create();
        $kasir->assignRole('kasir');

        $response = $this->actingAs($kasir)->get('suppliers');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Supplier');
    }
}
