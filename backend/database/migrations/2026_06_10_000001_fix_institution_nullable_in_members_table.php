<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah kolom institution menjadi nullable agar pendaftaran tanpa instansi bisa berhasil.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('institution', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('institution', 150)->nullable(false)->change();
        });
    }
};
