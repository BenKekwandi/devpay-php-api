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

        Schema::table('accounts', function (Blueprint $table) {
           $table->dropColumn('type');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->enum('type', ['reseller', 'account'])->default('account');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->enum('type', ['customer', 'supplier', 'both'])->default('account');
        });
    }
};
