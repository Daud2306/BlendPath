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
        Schema::create('resource', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->integer('tutorial_id')->nullable()->index('tutorial_id');
            $table->integer('tanya_id')->nullable()->index('tanya_id');
            $table->integer('jawab_id')->nullable()->index('jawab_id');
            $table->string('resource_link');

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
};
