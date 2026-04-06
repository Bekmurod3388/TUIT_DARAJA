<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payme_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('payme_transaction_id')->unique();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('amount');
            $table->bigInteger('payme_time');
            $table->integer('state');
            $table->unsignedSmallInteger('reason')->nullable();
            $table->timestamp('create_time')->nullable();
            $table->timestamp('perform_time')->nullable();
            $table->timestamp('cancel_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payme_transactions');
    }
};
