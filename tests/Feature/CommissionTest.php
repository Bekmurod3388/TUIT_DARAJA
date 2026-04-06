<?php

namespace Tests\Feature;

use App\Models\Commission;
use App\Models\User;
use App\Models\Specalization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_commission()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $spec = Specalization::factory()->create();
        $this->actingAs($admin);
        $response = $this->post('/admin/commissions', [
            'specalization_id' => $spec->id,
            'chairman' => 'Chairman Name',
            'deputy' => 'Deputy Name',
            'secretary' => 'Secretary Name',
            'members' => "Member1, Member2\nMember3",
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'specalization_id' => $spec->id,
            'chairman' => 'Chairman Name',
        ]);

        $commission = Commission::query()->latest('id')->firstOrFail();

        $this->assertSame(['Member1', 'Member2', 'Member3'], $commission->members);
    }

    public function test_admin_can_view_commissions()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->get('/admin/commissions');
        $response->assertStatus(200);
    }
} 
