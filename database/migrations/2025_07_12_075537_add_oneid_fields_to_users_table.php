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
        Schema::table('users', function (Blueprint $table) {
            $table->string('oneid_id')->nullable()->unique();
            $table->text('oneid_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            try {
                $table->dropUnique(['oneid_id']);
            } catch (\Throwable $e) {
                // SQLite yoki boshqa xatolarni e'tiborsiz qoldiramiz
            }
            if (Schema::hasColumn('users', 'oneid_id')) {
                $table->dropColumn('oneid_id');
            }
            if (Schema::hasColumn('users', 'oneid_token')) {
                $table->dropColumn('oneid_token');
            }
        });
    }
};
