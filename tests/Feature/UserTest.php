<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Testovich',
            'phone' => '998901112233',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', ['phone' => '998901112233']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'phone' => '998901112233',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'phone' => '998901112233',
            'password' => 'password',
        ]);
        $response->assertRedirect('/my-applications');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
} 