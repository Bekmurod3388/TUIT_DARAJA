<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('semester');
            $table->index('is_active');
        });

        Schema::table('specalizations', function (Blueprint $table) {
            $table->foreignId('academic_year_id')
                ->nullable()
                ->after('program_name_id')
                ->constrained('academic_years')
                ->nullOnDelete();

            $table->index('academic_year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specalizations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_year_id');
        });

        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropColumn('is_active');
        });
    }
};
