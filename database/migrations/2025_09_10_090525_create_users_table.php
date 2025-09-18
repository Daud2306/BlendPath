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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->string('nama');
            $table->string('email')->unique('email');
            $table->string('password');
            $table->enum('role', ['user', 'admin']);
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
        Schema::dropIfExists('users');
    }
};
