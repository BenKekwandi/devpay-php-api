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
        Schema::table('account_groups', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->boolean('is_active')->default(true)->after('title');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_groups', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->dropSoftDeletes();
            $table->dropColumn(['is_active']);
        });
    }
};
