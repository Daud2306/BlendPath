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
        Schema::create('jawab', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->integer('user_id')->index('user_id');
            $table->integer('tanya_id')->index('tanya_id');
            $table->text('konten');
            $table->boolean('is_accepted');
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
        Schema::dropIfExists('jawab');
    }
};
