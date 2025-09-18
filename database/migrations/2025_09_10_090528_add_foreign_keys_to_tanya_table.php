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
        Schema::table('tanya', function (Blueprint $table) {
            $table->foreign(['tutorial_id'], 'tanya_ibfk_1')->references(['id'])->on('tutorial')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'tanya_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanya', function (Blueprint $table) {
            $table->dropForeign('tanya_ibfk_1');
            $table->dropForeign('tanya_ibfk_2');
        });
    }
};
