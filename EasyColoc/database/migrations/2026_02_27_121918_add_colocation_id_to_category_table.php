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
        Schema::table('category', function (Blueprint $table) {
            $table->foreignId('colocation_id')->after('id')->nullable()->constrained('colocation')->onDelete('cascade');
            $table->dropUnique(['name']);
            $table->unique(['name', 'colocation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropUnique(['name', 'colocation_id']);
            $table->unique('name');
            $table->dropForeign(['colocation_id']);
            $table->dropColumn('colocation_id');
        });
    }
};
