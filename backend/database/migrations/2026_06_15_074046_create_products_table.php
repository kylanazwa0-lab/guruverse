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
            $table->id();
            $table->string('name');
            $table->string('author')->nullable();
            $table->string('type'); // e-book, pelatihan, merchandise
            $table->decimal('price', 10, 2)->default(0); // Harga Normal / Non-Member
            $table->decimal('member_price', 10, 2)->nullable(); // Harga khusus Member
            $table->string('image')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_color')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
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
