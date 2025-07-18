<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Specalization;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_application()
    {
        $user = User::factory()->create();
        $spec = Specalization::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/applications', [
            'specalization_id' => $spec->id,
            'organization' => 'Test Org',
            'subject' => 'Test Subject',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
        ]);
    }

    public function test_user_can_view_applications()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/my-applications');
        $response->assertStatus(200);
    }

    public function test_user_can_edit_application()
    {
        $user = User::factory()->create();
        $spec = Specalization::factory()->create();
        $app = Application::factory()->create([
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
        ]);
        $this->actingAs($user);
        $response = $this->get('/my-applications/' . $app->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_user_can_view_payment_page()
    {
        $user = User::factory()->create();
        $spec = Specalization::factory()->create();
        $app = Application::factory()->create([
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
        ]);
        $this->actingAs($user);
        $response = $this->get('/applications/' . $app->id . '/pay');
        $response->assertStatus(200);
    }
} 