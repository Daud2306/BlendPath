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
        Schema::create('tanya', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->integer('user_id')->index('user_id');
            $table->integer('tutorial_id')->index('tutorial_id');
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
        Schema::dropIfExists('tanya');
    }
};
