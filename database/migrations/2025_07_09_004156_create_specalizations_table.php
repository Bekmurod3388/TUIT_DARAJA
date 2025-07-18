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
        Schema::create('specalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_name_id')->constrained('program_names')->onDelete('cascade');
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->integer('price')->default(0); // to'lov summasi (so'mda)
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specalizations');
    }
};
