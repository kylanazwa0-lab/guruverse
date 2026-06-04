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
        // Jika tabel sudah ada (dari legacy system), skip pembuatan
        if (Schema::hasTable('members')) {
            return;
        }

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 50)->unique();
            $table->string('full_name', 150);
            $table->string('username', 50)->unique();
            $table->string('institution', 150);
            $table->string('password', 255);
            $table->string('phone', 20)->nullable();
            $table->longText('photo_base64')->nullable();
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Indexes untuk performa query
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};