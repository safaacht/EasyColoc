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
        Schema::table('settlement', function (Blueprint $table) {
            $table->foreignId('payer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('colocation_id')->constrained('colocation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settlement', function (Blueprint $table) {
            $table->dropForeign(['payer_id']);
            $table->dropForeign(['receiver_id']);
            $table->dropForeign(['colocation_id']);
            $table->dropColumn(['payer_id', 'receiver_id', 'colocation_id']);
        });
    }
};
