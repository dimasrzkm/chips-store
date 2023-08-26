<?php

namespace Tests\Feature;

use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ShowSuppliers;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_supplier_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        $response = $this->actingAs($user)
            ->get('suppliers');
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
    public function pemilik_can_search_data_suppliers()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Supplier::factory(6)->create();

        $this->assertCount(6, Supplier::all());

        Livewire::withQueryParams(['search' => Supplier::find(1)->name])
            ->test(ShowSuppliers::class)
            ->assertSee(Supplier::find(1)->name);
    }
}
