<?php

namespace Tests\Feature;

use App\Livewire\Products\CreateProducts;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    // Start Bagian Gudang Test

    /** @test */
    public function user_with_role_bagian_gudang_can_see_product_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat produk', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat produk');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('products');
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_see_the_form_adding_product()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah produk', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah produk');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('products')
            ->assertSee('Produk');

        $response = $this->actingAs($user)->get('products/create');
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_add_product()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Livewire::actingAs($user)
            ->test(CreateProducts::class)
            ->set('form.name', 'Kripik Pisang Coklat')
            ->set('form.initial_price', $hargaAwal = 12000)
            ->set('form.percentage_profit', $persentaseUntung = 25)
            ->set('form.sale_price', ($hargaAwal) + ($persentaseUntung / 100) * $hargaAwal)
            ->set('form.stock', 0)
            ->call('submit')
            ->assertRedirect('products');

        $this->assertCount(1, Product::all());
    }

    /** @test */
    public function bagian_gudang_can_see_the_form_edit_product()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah produk', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah produk');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Livewire::actingAs($user)
            ->test(CreateProducts::class)
            ->set('form.name', 'Kripik Pisang Coklat')
            ->set('form.initial_price', $hargaAwal = 12000)
            ->set('form.percentage_profit', $persentaseUntung = 25)
            ->set('form.sale_price', ($hargaAwal) + ($persentaseUntung / 100) * $hargaAwal)
            ->set('form.stock', 0)
            ->call('submit');

        $product = Product::first();

        // $this->actingAs($user)
        //     ->get('products')
        //     ->assertSee('Edit');

        $response = $this->actingAs($user)->get("products/$product->name/edit");
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_edit_product()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Livewire::actingAs($user)
            ->test(CreateProducts::class)
            ->set('form.name', 'Kripik Pisang Coklat')
            ->set('form.initial_price', $hargaAwal = 12000)
            ->set('form.percentage_profit', $persentaseUntung = 25)
            ->set('form.sale_price', ($hargaAwal) + ($persentaseUntung / 100) * $hargaAwal)
            ->set('form.stock', 0)
            ->call('submit');

        $this->assertCount(1, Product::all());

        $product = Product::first();

        $response = $this->actingAs($user)->get("products/$product->name/edit");
        $response->assertOk();

        Livewire::actingAs($user)
            ->test(EditProducts::class, ['product' => $product])
            ->set('form.name', 'Kripik Pisang Coklat -edited')
            ->set('form.initial_price', $product->initial_price)
            ->set('form.percentage_profit', $product->percentage_profit)
            ->set('form.sale_price', $product->sale_price)
            ->set('form.stock', $product->stock)
            ->call('submit')
            ->assertRedirect('products');

        $this->assertEquals('Kripik Pisang Coklat -edited', Product::first()->name);
    }

    /** @test */
    public function bagian_gudang_can_see_hapus_button_to_delete_data_product()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus produk', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus produk');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('products');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Produk!');
    }

    /** @test */
    public function bagian_gudang_can_delete_data_product()
    {
        $this->withoutExceptionHandling();
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Livewire::actingAs($user)
            ->test(CreateProducts::class)
            ->set('form.name', 'Kripik Pisang Coklat')
            ->set('form.initial_price', $hargaAwal = 12000)
            ->set('form.percentage_profit', $persentaseUntung = 25)
            ->set('form.sale_price', ($hargaAwal) + ($persentaseUntung / 100) * $hargaAwal)
            ->set('form.stock', 0)
            ->call('submit');

        Livewire::actingAs($user)
            ->test(ShowProducts::class)
            ->call('getDataForDelete', Product::first())
            ->call('deleteProduct')
            ->assertRedirect('products');
    }

    // End Bagian Gudang Test
}
