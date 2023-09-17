<?php

namespace Tests\Feature;

use App\Livewire\Stocks\CreateStocks;
use App\Livewire\Stocks\EditStocks;
use App\Livewire\Stocks\ShowStocks;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    // Start Bagian Gudang Test

    /** @test */
    public function user_with_role_bagian_gudang_can_see_bahan_baku_page()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat bahan baku');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_see_the_form_adding_bahan_baku()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah bahan baku');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $this->actingAs($user)
            ->get('stocks')
            ->assertSee('Pengadaan Bahan Baku');

        $response = $this->actingAs($user)->get('stocks/create');
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_add_bahan_baku()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Supplier::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateStocks::class)
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit')
            ->assertRedirect('stocks');

        $this->assertCount(1, Stock::all());
    }

    /** @test */
    public function bagian_gudang_can_see_the_form_edit_bahan_baku()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah bahan baku');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Supplier::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateStocks::class)
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit');

        $stock = Stock::first();

        $this->actingAs($user)
            ->get('stocks')
            ->assertSee('Edit');

        $response = $this->actingAs($user)->get("stocks/$stock->id/edit");
        $response->assertOk();
    }

    /** @test */
    public function bagian_gudang_can_edit_bahan_baku()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        $stock = Stock::first();

        $response = $this->actingAs($user)->get("stocks/$stock->id/edit");
        $response->assertOk();

        Livewire::actingAs($user)
            ->test(EditStocks::class, ['stock' => $stock])
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang -edited')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit')
            ->assertRedirect('stocks');

        $this->assertEquals('pisang -edited', Stock::first()->nama);
    }

    /** @test */
    public function bagian_gudang_can_see_hapus_button_to_delete_data_stock()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus bahan baku');

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Stock!');
    }

    /** @test */
    public function bagian_gudang_can_delete_data_stock()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        $stock = Stock::first();

        Livewire::actingAs($user)
            ->test(ShowStocks::class)
            ->call('getDataForDelete', $stock)
            ->call('deleteStock')
            ->assertRedirect('stocks');

        $this->assertCount(0, Stock::all());
    }

    /** @test */
    public function bagian_gudang_can_search_data_stocks()
    {
        Role::create(['name' => 'bagian gudang', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('bagian gudang');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        Livewire::withQueryParams(['search' => Stock::find(1)->nama])
            ->test(ShowStocks::class)
            ->assertSee(Stock::find(1)->nama);
    }

    // End Bagian Gudang Test

    //Start Pemilik Test
    /** @test */
    public function user_with_role_pemilik_can_see_bahan_baku_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'melihat bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('melihat bahan baku');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_see_the_form_adding_bahan_baku()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menambah bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menambah bahan baku');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $this->actingAs($user)
            ->get('stocks')
            ->assertSee('Pengadaan Bahan Baku');

        $response = $this->actingAs($user)->get('stocks/create');
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_add_bahan_baku()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Supplier::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateStocks::class)
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit')
            ->assertRedirect('stocks');

        $this->assertCount(1, Stock::all());
    }

    /** @test */
    public function pemilik_can_see_the_form_edit_bahan_baku()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'mengubah bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('mengubah bahan baku');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Supplier::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateStocks::class)
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit');

        $stock = Stock::first();

        $this->actingAs($user)
            ->get('stocks')
            ->assertSee('Edit');

        $response = $this->actingAs($user)->get("stocks/$stock->id/edit");
        $response->assertOk();
    }

    /** @test */
    public function pemilik_can_edit_bahan_baku()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        $stock = Stock::first();

        $response = $this->actingAs($user)->get("stocks/$stock->id/edit");
        $response->assertOk();

        Livewire::actingAs($user)
            ->test(EditStocks::class, ['stock' => $stock])
            ->set('form.supplier_id', Supplier::first()->id)
            ->set('form.name', 'pisang -edited')
            ->set('form.purchase_date', '12/1/2001')
            ->set('form.price', 12000)
            ->set('form.total', 2)
            ->call('submit')
            ->assertRedirect('stocks');

        $this->assertEquals('pisang -edited', Stock::first()->nama);
    }

    /** @test */
    public function pemilik_can_see_hapus_button_to_delete_data_stock()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        Permission::create(['name' => 'menghapus bahan baku', 'guard_name' => 'web']);

        $role = Role::findById(1);
        $role->givePermissionTo('menghapus bahan baku');

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertSee('Hapus');
        $response->assertSee('Menghapus Data Stock!');
    }

    /** @test */
    public function pemilik_can_delete_data_stock()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        $stock = Stock::first();

        Livewire::actingAs($user)
            ->test(ShowStocks::class)
            ->call('getDataForDelete', $stock)
            ->call('deleteStock')
            ->assertRedirect('stocks');

        $this->assertCount(0, Stock::all());
    }

    /** @test */
    public function pemilik_can_search_data_stocks()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('pemilik');

        Stock::factory()->create();

        $this->assertCount(1, Stock::all());

        Livewire::withQueryParams(['search' => Stock::find(1)->nama])
            ->test(ShowStocks::class)
            ->assertSee(Stock::find(1)->nama);
    }

    // End Bagian Pemilik

    // Start Kasir

    /** @test */
    public function user_with_role_kasir_cannot_see_bahan_baku_page()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertStatus(403);
    }

    /** @test */
    public function kasir_cannot_add_bahan_baku()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('stocks')
            ->assertDontSee('Pengadaan Bahan Baku')
            ->assertStatus(403);

        $response = $this->actingAs($user)->get('stocks/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function kasir_cannot_edit_bahan_baku()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('kasir');

        $this->actingAs($user)
            ->get('stocks')
            ->assertDontSee('Edit')
            ->assertStatus(403);

        $stock = Stock::factory()->create();

        $response = $this->actingAs($user)->get("stocks/$stock->nama/edit");
        $response->assertStatus(403);
    }

    /** @test */
    public function kasir_cannot_delete_data_stock()
    {
        Role::create(['name' => 'kasir', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('kasir');

        $response = $this->actingAs($user)->get('stocks');
        $response->assertDontSee('Hapus');
        $response->assertDontSee('Menghapus Data Stock!');
    }

    // End Kasir

}
