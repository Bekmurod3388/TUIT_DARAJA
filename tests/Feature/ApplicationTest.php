<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Specalization;
use App\Models\Application;
use App\Models\Subject;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_application()
    {
        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);
        $spec = Specalization::factory()->create([
            'academic_year_id' => $academicYear->id,
        ]);
        $this->actingAs($user);
        $response = $this->post('/applications', [
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Example',
            'specalization_id' => $spec->id,
            'subject' => 'Test Subject',
            'education_type' => 'Tayanch doktorantura (PhD)',
            'organization_type' => 'uzmu',
            'phone' => '998901112233',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
            'organization' => 'TATU',
            'subject' => 'Test Subject',
        ]);
    }

    public function test_user_can_view_applications()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/my-applications');
        $response->assertStatus(200);
    }

    public function test_specalizations_endpoint_deduplicates_same_named_visible_programs(): void
    {
        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);

        Specalization::factory()->create([
            'name' => 'Sun\'iy intellekt',
            'is_visible' => true,
            'academic_year_id' => $academicYear->id,
        ]);

        Specalization::factory()->create([
            'name' => ' sun\'iy intellekt ',
            'is_visible' => true,
            'academic_year_id' => $academicYear->id,
        ]);

        $this->actingAs($user)
            ->getJson('/applications/specalizations')
            ->assertOk()
            ->assertJsonCount(1, 'specalizations');
    }

    public function test_subjects_endpoint_merges_subjects_from_duplicate_specialization_names(): void
    {
        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);

        $firstSpecalization = Specalization::factory()->create([
            'name' => 'Data Science',
            'is_visible' => true,
            'academic_year_id' => $academicYear->id,
        ]);

        $secondSpecalization = Specalization::factory()->create([
            'name' => ' data science ',
            'is_visible' => true,
            'academic_year_id' => $academicYear->id,
        ]);

        $math = Subject::factory()->create(['fan' => 'Matematika']);
        $english = Subject::factory()->create(['fan' => 'Ingliz tili']);

        $firstSpecalization->subjects()->attach($math->fan_id);
        $secondSpecalization->subjects()->attach($english->fan_id);

        $this->actingAs($user)
            ->getJson("/applications/specalizations/{$firstSpecalization->id}/subjects")
            ->assertOk()
            ->assertJsonCount(2, 'subjects')
            ->assertJsonFragment(['name' => 'Matematika'])
            ->assertJsonFragment(['name' => 'Ingliz tili']);
    }

    public function test_user_can_edit_application()
    {
        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);
        $spec = Specalization::factory()->create([
            'academic_year_id' => $academicYear->id,
        ]);
        $app = Application::factory()->create([
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
            'academic_year_id' => $academicYear->id,
        ]);
        $this->actingAs($user);
        $response = $this->get('/my-applications/' . $app->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_user_can_view_payment_page()
    {
        config(['services.payme.merchant_id' => 'test-merchant']);

        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);
        $spec = Specalization::factory()->create([
            'academic_year_id' => $academicYear->id,
        ]);
        $app = Application::factory()->create([
            'user_id' => $user->id,
            'specalization_id' => $spec->id,
            'academic_year_id' => $academicYear->id,
        ]);
        $this->actingAs($user);
        $response = $this->get('/applications/' . $app->id . '/pay');
        $response->assertRedirect();
        $this->assertStringContainsString('checkout.paycom.uz', (string) $response->headers->get('Location'));
    }

    public function test_user_cannot_edit_another_users_application()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $app = Application::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user)
            ->get('/my-applications/' . $app->id . '/edit')
            ->assertNotFound();
    }

    public function test_user_cannot_pay_for_another_users_application()
    {
        config(['services.payme.merchant_id' => 'test-merchant']);

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $app = Application::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user)
            ->get('/applications/' . $app->id . '/pay')
            ->assertNotFound();
    }

    public function test_certificate_requires_paid_accepted_and_scored_application()
    {
        $user = User::factory()->create();
        $app = Application::factory()->create([
            'user_id' => $user->id,
            'payment_status' => 'pending',
            'status' => 'pending',
            'is_scored' => true,
            'score' => 86,
        ]);

        $this->actingAs($user)
            ->get('/applications/' . $app->id . '/certificate')
            ->assertForbidden();
    }

    public function test_application_files_get_unique_names_even_with_same_timestamp(): void
    {
        Storage::fake('local');
        Carbon::setTestNow('2026-04-06 10:00:00');

        $user = User::factory()->create();
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'bahorgi',
            'is_active' => true,
        ]);
        $spec = Specalization::factory()->create([
            'academic_year_id' => $academicYear->id,
        ]);

        $this->actingAs($user)->post('/applications', [
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Example',
            'specalization_id' => $spec->id,
            'subject' => 'Subject A',
            'education_type' => 'Tayanch doktorantura (PhD)',
            'organization_type' => 'other',
            'organization' => 'Example Org',
            'phone' => '998901112233',
            'direction_file' => UploadedFile::fake()->create('direction.pdf', 100, 'application/pdf'),
            'receipt_file' => UploadedFile::fake()->create('receipt.pdf', 100, 'application/pdf'),
        ])->assertRedirect();

        $this->actingAs($user)->post('/applications', [
            'last_name' => 'Test',
            'first_name' => 'User',
            'middle_name' => 'Example',
            'specalization_id' => $spec->id,
            'subject' => 'Subject B',
            'education_type' => 'Tayanch doktorantura (PhD)',
            'organization_type' => 'other',
            'organization' => 'Example Org',
            'phone' => '998901112233',
            'direction_file' => UploadedFile::fake()->create('direction.pdf', 100, 'application/pdf'),
            'receipt_file' => UploadedFile::fake()->create('receipt.pdf', 100, 'application/pdf'),
        ])->assertRedirect();

        $paths = Application::query()
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->pluck('direction_file')
            ->all();

        $this->assertCount(2, array_unique($paths));
        $this->assertNotSame($paths[0], $paths[1]);
        Storage::disk('local')->assertExists($paths[0]);
        Storage::disk('local')->assertExists($paths[1]);

        Carbon::setTestNow();
    }

    public function test_payment_status_migration_backfills_legacy_schema(): void
    {
        Schema::dropIfExists('payme_transactions');
        Schema::dropIfExists('applications');

        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('specalization_id')->constrained('specalizations')->onDelete('cascade');
            $table->string('organization');
            $table->string('subject');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        $migration = require base_path('database/migrations/2025_07_16_114124_add_payment_status_to_applications_table.php');
        $migration->up();

        $this->assertTrue(Schema::hasColumn('applications', 'payment_status'));
    }
} 
