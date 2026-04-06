<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Specalization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymeMerchantTest extends TestCase
{
    use RefreshDatabase;

    public function test_payme_perform_transaction_marks_application_as_paid(): void
    {
        config([
            'services.payme.login' => 'Paycom',
            'services.payme.key' => 'secret-key',
        ]);

        $specalization = Specalization::factory()->create([
            'price' => 125000,
        ]);

        $application = Application::factory()->create([
            'specalization_id' => $specalization->id,
        ]);

        $headers = $this->merchantHeaders();

        $this->withHeaders($headers)->postJson('/payme/callback', [
            'id' => 1,
            'method' => 'CreateTransaction',
            'params' => [
                'id' => 'txn-1',
                'time' => now()->getTimestampMs(),
                'amount' => 12500000,
                'account' => [
                    'order_id' => $application->id,
                ],
            ],
        ])->assertOk();

        $this->withHeaders($headers)->postJson('/payme/callback', [
            'id' => 2,
            'method' => 'PerformTransaction',
            'params' => [
                'id' => 'txn-1',
            ],
        ])->assertOk()
            ->assertJsonPath('result.state', 2);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'payment_status' => 'paid',
        ]);

        $this->assertDatabaseHas('payme_transactions', [
            'payme_transaction_id' => 'txn-1',
            'state' => 2,
        ]);
    }

    public function test_payme_rejects_invalid_basic_auth(): void
    {
        $this->postJson('/payme/callback', [
            'id' => 1,
            'method' => 'CheckPerformTransaction',
            'params' => [],
        ])->assertStatus(401)
            ->assertJsonPath('error.code', -32504);
    }

    public function test_payme_rejects_second_active_transaction_for_same_application(): void
    {
        config([
            'services.payme.login' => 'Paycom',
            'services.payme.key' => 'secret-key',
        ]);

        $specalization = Specalization::factory()->create([
            'price' => 125000,
        ]);

        $application = Application::factory()->create([
            'specalization_id' => $specalization->id,
        ]);

        $headers = $this->merchantHeaders();

        $this->withHeaders($headers)->postJson('/payme/callback', [
            'id' => 1,
            'method' => 'CreateTransaction',
            'params' => [
                'id' => 'txn-1',
                'time' => now()->getTimestampMs(),
                'amount' => 12500000,
                'account' => [
                    'order_id' => $application->id,
                ],
            ],
        ])->assertOk();

        $this->withHeaders($headers)->postJson('/payme/callback', [
            'id' => 2,
            'method' => 'CreateTransaction',
            'params' => [
                'id' => 'txn-2',
                'time' => now()->addSecond()->getTimestampMs(),
                'amount' => 12500000,
                'account' => [
                    'order_id' => $application->id,
                ],
            ],
        ])->assertOk()
            ->assertJsonPath('error.code', -31008);

        $this->assertDatabaseCount('payme_transactions', 1);
    }

    private function merchantHeaders(): array
    {
        return [
            'Authorization' => 'Basic '.base64_encode('Paycom:secret-key'),
        ];
    }
}
