<?php

namespace Tests\Feature;

use App\Livewire\Permissions\CreatePermissions;
use App\Livewire\Permissions\EditPermissions;
use App\Livewire\Permissions\ShowPermissions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_the_permissions_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('permissions');
        $response->assertOk();
    }

    /** @test */
    public function user_can_see_form_create_permissions()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('permissions/create');
        $response->assertOk();
    }

    /** @test */
    public function user_can_add_permission_data()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreatePermissions::class)
            ->set('form.name', 'melihat izin')
            ->set('form.guard_name', 'web')
            ->call('createPermission')
            ->assertRedirect('permissions');

        $this->assertCount(1, Permission::all());
    }

    /** @test */
    public function user_can_edit_permission_data()
    {
        $permission = Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        $user = User::factory()->create();

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
    public function user_can_delete_permission_data()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::create(['name' => 'melihat izin', 'guard_name' => 'web']);
        $user = User::factory()->create();

        $this->assertCount(1, Permission::all());

        Livewire::actingAs($user)
            ->test(ShowPermissions::class)
            ->call('getIdForDelete', $permission)
            ->call('deletePermission', $permission)
            ->assertRedirect('permissions');

        $this->assertCount(0, Permission::all());
    }
}
