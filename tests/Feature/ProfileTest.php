<?php

use App\Livewire\Profile\UpdatePassword;
use App\Livewire\Profile\UpdateProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_visit_form_change_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('profile/'.$user->id);
        $response->assertOk();
        $response->assertSee('Profile Information');
    }

    /** @test */
    public function user_can_update_information()
    {
        $user = User::factory()->create(['name' => 'dimas']);
        $this->assertCount(1, User::all());
        $this->assertEquals('dimas', User::first()->name);

        Livewire::actingAs($user)
            ->test(UpdateProfile::class, ['user' => $user])
            ->set('form.name', 'salma')
            ->set('form.email', 'dimas@gmail.com')
            ->set('form.username', $user->username)
            ->set('form.address', 'dummy')
            ->set('form.telephone_number', '089512121')
            ->call('updateProfile')
            ->assertRedirect('profile/'.$user->username);

        $this->assertCount(1, User::all());
        $this->assertEquals('salma', User::first()->name);
    }

    /** @test */
    public function user_can_update_password()
    {
        $user = User::factory()->create();
        $this->assertCount(1, User::all());

        Livewire::actingAs($user)
            ->test(UpdatePassword::class)
            ->set('form.oldPassword', 'password')
            ->set('form.newPassword', 'passwordBaru')
            ->set('form.newConfirmPassword', 'passwordBaru')
            ->call('updatePassword')
            ->assertRedirect('profile/'.$user->username);
    }
}
