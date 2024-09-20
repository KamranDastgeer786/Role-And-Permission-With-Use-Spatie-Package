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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Product name
            $table->text('description'); // Product description
            $table->integer('quantity'); // Product quantity
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade'); // Foreign key to categories table
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key to users table
            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
