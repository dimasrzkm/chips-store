<?php

namespace Tests\Feature;

use App\Livewire\Users\CreateUsers;
use App\Livewire\Users\EditUsers;
use App\Livewire\Users\ShowUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_role_pemilik_can_see_the_users_page()
    {
        Role::create(['name' => 'pemilik', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('pemilik');
        $response = $this->actingAs($user)
            ->get('users');
        $response->assertOk();
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
}
