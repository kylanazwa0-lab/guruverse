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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->string('file_url'); // Path S3: "certificates/student-1-course-5.pdf"
            $table->string('certificate_number')->unique();
            $table->timestamp('issued_at');
            $table->timestamps();

            // Note: Foreign keys akan ditambahkan di migration terpisah
            // karena tabel courses dan users mungkin belum ada saat migration awal
            $table->index(['student_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
