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
        Schema::table('tutorial', function (Blueprint $table) {
            $table->foreign(['roadmap_id'], 'tutorial_ibfk_1')->references(['id'])->on('roadmap')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutorial', function (Blueprint $table) {
            $table->dropForeign('tutorial_ibfk_1');
        });
    }
};
