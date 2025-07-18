<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProgramName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_program_name()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->post('/admin/program-names', [
            'name' => 'Test Program',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('program_names', ['name' => 'Test Program']);
    }

    public function test_admin_can_view_program_names()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->get('/admin/program-names');
        $response->assertStatus(200);
    }
} 