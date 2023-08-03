<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_login_form()
    {
        $response = $this->get('login');
        $response->assertSuccessful();
        $response->assertSee('Login');
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirectToRoute('dashboard');
    }

    /** @test */
    public function an_email_is_required_to_login()
    {
        $response = $this->post('login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function an_password_is_required_to_login()
    {
        $user = User::factory()->create();
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => '',
        ]);
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_login_with_wrong_credential()
    {
        $user = User::factory()->create();
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'inisalah',
        ]);
        $response->assertRedirectToRoute('login');
        $this->assertGuest();
    }

    /** @test */
    public function user_already_login_cannot_view_login_form()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('login');
        $response->assertRedirectToRoute('dashboard');
    }

    /** @test */
    public function user_not_authenticated_cannot_visit_dashboard()
    {
        $response = $this->get('dashboard');
        $response->assertRedirectToRoute('login');
    }
}
