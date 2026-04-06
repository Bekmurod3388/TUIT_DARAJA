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
        Schema::table('applications', function (Blueprint $table) {
            $table->index('status');
            $table->index('payment_status');
        });

        Schema::table('specalizations', function (Blueprint $table) {
            $table->index('is_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
        });

        Schema::table('specalizations', function (Blueprint $table) {
            $table->dropIndex(['is_visible']);
        });
    }
};
