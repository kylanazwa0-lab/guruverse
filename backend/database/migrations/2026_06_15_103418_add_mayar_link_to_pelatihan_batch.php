<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gb_mengajar_pelatihan_batch', function (Blueprint $table) {
            // Link pembayaran Mayar.id untuk batch ini
            $table->string('mayar_link')->nullable()->after('sisa_kursi');
        });

        // Tambah kolom payment_status ke peserta
        Schema::table('gb_mengajar_peserta_pelatihan', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'free'])->default('pending')->after('status');
            $table->string('payment_ref')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('gb_mengajar_pelatihan_batch', function (Blueprint $table) {
            $table->dropColumn('mayar_link');
        });
        Schema::table('gb_mengajar_peserta_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_ref']);
        });
    }
};
