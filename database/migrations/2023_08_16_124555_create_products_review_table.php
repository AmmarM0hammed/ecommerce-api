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
        Schema::create('products_review', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained("products","id")->cascadeOnDelete();
            $table->foreignId("user_id")->constrained("users","id")->cascadeOnDelete();
            $table->float("rating",1,1)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_review');
    }
};
