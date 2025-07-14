<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('education_type')->nullable();
            $table->string('oac_file')->nullable();
            $table->string('direction_file')->nullable();
            $table->string('receipt_file')->nullable();
            $table->string('work_order_file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'last_name', 'first_name', 'middle_name', 'phone', 'education_type',
                'oac_file', 'direction_file', 'receipt_file', 'work_order_file'
            ]);
        });
    }
}; 