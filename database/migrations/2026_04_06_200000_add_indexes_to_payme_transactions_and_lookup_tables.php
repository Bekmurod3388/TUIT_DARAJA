<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payme_transactions', function (Blueprint $table) {
            $table->index(['application_id', 'state'], 'payme_transactions_application_state_index');
            $table->index('payme_time', 'payme_transactions_payme_time_index');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->index('created_at', 'applications_created_at_index');
        });

        Schema::table('program_names', function (Blueprint $table) {
            $table->index('name', 'program_names_name_index');
        });
    }

    public function down(): void
    {
        Schema::table('payme_transactions', function (Blueprint $table) {
            $table->dropIndex('payme_transactions_application_state_index');
            $table->dropIndex('payme_transactions_payme_time_index');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex('applications_created_at_index');
        });

        Schema::table('program_names', function (Blueprint $table) {
            $table->dropIndex('program_names_name_index');
        });
    }
};
