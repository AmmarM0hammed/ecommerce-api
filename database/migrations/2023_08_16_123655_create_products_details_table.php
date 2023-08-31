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
        Schema::create('products_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained("products","id")->cascadeOnDelete();
            $table->text("description")->nullable();
            $table->integer("quantity");
            $table->json("sizes")->nullable();
            $table->json("colors")->nullable();
            $table->text("product_image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_details');
    }
};
