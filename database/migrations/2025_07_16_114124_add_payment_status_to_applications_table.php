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
        if (!Schema::hasColumn('applications', 'payment_status')) {
            Schema::table('applications', function (Blueprint $table) {
                $table->string('payment_status')->default('pending')->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty because the base applications migration now
        // owns the payment_status column on fresh installs.
    }
};
