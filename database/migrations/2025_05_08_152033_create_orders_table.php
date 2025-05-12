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
            $table->string('order_number', 255);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('order_status', ["pending", "shipped", "delivered"])->default("pending");
            $table->enum('payment_method', ['stripe', 'paypal' , 'delivery'])->default('delivery');
            $table->boolean('payment_status')->default(0);
            $table->string('city_name');
            $table->string('address_name');
            $table->string('building_number');
            $table->decimal('total');
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
