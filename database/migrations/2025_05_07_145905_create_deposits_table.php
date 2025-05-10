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
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->integer('customer_id');
            $table->string('payment_method')->length(25);
            $table->string('sender_number')->length(50);
            $table->string('transaction_id')->length(50);
            $table->string('message')->length(255);
            $table->string('status')->length(25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
