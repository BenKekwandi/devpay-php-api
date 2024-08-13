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
        Schema::create('account_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->unsignedTinyInteger('payment_method_id');
            $table->unsignedTinyInteger('account_id');
            $table->string('remark');
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_payment_methods');
    }
};
