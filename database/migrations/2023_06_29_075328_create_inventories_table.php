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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('sku')->nullable();
            $table->string('delivery_fee');
            $table->string('description')->nullable();
            $table->json('additional_data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
