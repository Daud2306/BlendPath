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
            $table->foreignId('submodul_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('tanya_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('jawab_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('resource', 255);
            $table->string('type')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('size')->nullable();
            $table->string('original_name')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
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
