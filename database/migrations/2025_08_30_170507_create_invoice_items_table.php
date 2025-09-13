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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('product_name')->nullable(); //Produkte
            $table->integer('product_quantity')->nullable();
            $table->integer('quantity_type')->nullable();
            $table->integer('product_price')->nullable();
            $table->integer('product_discount')->nullable();
            $table->integer('product_discount_type')->nullable();
            $table->text('product_note')->nullable();
            $table->integer('product_amount')->nullable();
            $table->integer('product_pricing')->nullable(); //Brutto netto
            $table->integer('product_tax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
