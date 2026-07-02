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
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['mp3', 'mp4', 'pdf', 'doc', 'other'])->default('mp4');
            $table->string('file_url'); // Path S3: "materi/1234567890-abc123.mp4"
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('durasi')->nullable()->comment('Durasi dalam detik untuk video/audio');
            $table->timestamps();

            // Note: Foreign keys akan ditambahkan di migration terpisah
            // karena tabel courses dan users mungkin belum ada saat migration awal
            $table->index('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
