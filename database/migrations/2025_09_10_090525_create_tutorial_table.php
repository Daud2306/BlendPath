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
        Schema::create('tutorial', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->integer('roadmap_id')->index('roadmap_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->integer('sort_order');
            $table->text('konten');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial');
    }
};
