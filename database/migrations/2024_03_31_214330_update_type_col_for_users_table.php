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
            $table->dropColumn('type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['master', 'manager','account','integration'])->default('account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['MASTER', 'ACCOUNT','MANAGER','INTEGRATION'])->default('account');
        });
    }
};
