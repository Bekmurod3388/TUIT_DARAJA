<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specalization_id')->constrained('specalizations')->onDelete('cascade');
            $table->string('chairman'); // Komissiya raisi
            $table->string('deputy');   // Rais o‘rinbosar
            $table->string('secretary'); // Komissiya kotibi
            $table->text('members');    // Komissiya a’zolari (json yoki vergul bilan)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
}; 