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
        Schema::table('resource', function (Blueprint $table) {
            $table->foreign(['tanya_id'], 'resource_ibfk_1')->references(['id'])->on('tanya')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['jawab_id'], 'resource_ibfk_2')->references(['id'])->on('jawab')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['tutorial_id'], 'resource_ibfk_3')->references(['id'])->on('tutorial')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource', function (Blueprint $table) {
            $table->dropForeign('resource_ibfk_1');
            $table->dropForeign('resource_ibfk_2');
            $table->dropForeign('resource_ibfk_3');
        });
    }
};
