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
            $table->unsignedTinyInteger('account_id')->after('id');
            $table->enum('type', ['MASTER', 'ACCOUNT','MANAGER','INTEGRATION']);
            $table->string('lastname');
            $table->string('phone')->nullable()->after('email');
            $table->dateTime('last_login_date')->nullable();
            $table->string('username')->after('email_verified_at');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['type','lastname','phone','last_login_date','username','is_active','account_id']);
        });
    }
};
