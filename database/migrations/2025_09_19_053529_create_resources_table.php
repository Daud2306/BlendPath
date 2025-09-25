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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('tutorial_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('tanya_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('jawab_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('resource_link', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
