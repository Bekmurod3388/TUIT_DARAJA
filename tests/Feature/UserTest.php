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
        $initialSessionId = $this->app['session']->getId();

        $response = $this->post('/register', [
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Testovich',
            'phone' => '+998 (90) 111-22-33',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect('/my-applications');
        $this->assertDatabaseHas('users', ['phone' => '998901112233']);
        $this->assertAuthenticated();
        $this->assertNotSame($initialSessionId, $this->app['session']->getId());
    }

    public function test_user_can_login_with_formatted_phone()
    {
        $user = User::factory()->create([
            'phone' => '998901112233',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'phone' => '+998 (90) 111-22-33',
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

    public function test_admin_cannot_promote_user_to_superadmin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)->put('/admin/users/'.$user->id, [
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'phone' => $user->phone,
            'role' => 'superadmin',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
        ]);
    }

    public function test_admin_cannot_delete_another_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->delete('/admin/users/'.$otherAdmin->id)
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $otherAdmin->id,
        ]);
    }
} 
