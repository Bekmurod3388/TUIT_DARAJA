<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_subject()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->post('/admin/subjects', [
            'fan' => 'Matematika',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('subjects', ['fan' => 'Matematika']);
    }

    public function test_admin_can_view_subjects()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->get('/admin/subjects');
        $response->assertStatus(200);
    }
} 