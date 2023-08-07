<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_already_logged_in_can_see_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post('login', [
                'email' => $user->email,
                'password' => 'password',
            ]);
        $response->assertRedirectToRoute('dashboard');
    }

    /** @test */
    public function user_who_have_logged_in_can_log_out_from_the_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('login', [
                'email' => $user->email,
                'password' => 'password',
            ]);
        $response = $this->actingAs($user)->post('logout');
        $response->assertRedirectToRoute('login');
    }
}
