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
        Schema::create('submoduls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('modul_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->text('konten');
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submoduls');
    }
};
