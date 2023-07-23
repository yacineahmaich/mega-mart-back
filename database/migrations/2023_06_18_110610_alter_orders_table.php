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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_address');
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('note');
            $table->boolean('delivered')->default(false);
            $table->date('delivered_at')->nullable();
            $table->date('paid_at')->nullable();
            $table->text('checkout_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
