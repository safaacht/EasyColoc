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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('membregenerale')->change();
        });

        Schema::table('membership', function (Blueprint $table) {
            $table->decimal('solde', 5, 2)->default(0)->change();
            $table->dateTime('left_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(null)->change();
        });

        Schema::table('membership', function (Blueprint $table) {
            $table->decimal('solde', 5, 2)->change();
            $table->dateTime('left_at')->nullable(false)->change();
        });
    }
};
