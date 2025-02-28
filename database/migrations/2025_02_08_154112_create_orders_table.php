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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // user_id foreign key tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // event_id foreign key tabel events
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            // quantity
            $table->integer('quantity');
            // total_price
            $table->decimal('total_price', 15, 2);
            // event_date'
            $table->date('event_date');
            // status_payment enum pending, success, cancel default pending
            $table->enum('status_payment', ['pending', 'success', 'cancel'])->default('pending');
            $table->string('payment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};