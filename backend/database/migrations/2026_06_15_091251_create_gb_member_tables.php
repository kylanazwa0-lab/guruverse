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
        Schema::create('gb_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable();
            $table->float('duration_hours')->default(0);
            $table->string('level')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gb_enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->string('status')->default('active');
            $table->integer('progress_percent')->default(0);
            $table->datetime('enrolled_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->integer('completed_modules')->default(0);
        });

        Schema::create('gb_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('module_number')->default(1);
            $table->string('title');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->text('quiz_data')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gb_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->string('certificate_number')->nullable();
            $table->datetime('issued_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });

        Schema::create('gb_discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('module_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('body');
            $table->string('category')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });

        Schema::create('gb_discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_id');
            $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('gb_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('module_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('score')->default(0);
            $table->text('answers')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gb_quiz_results');
        Schema::dropIfExists('gb_discussion_replies');
        Schema::dropIfExists('gb_discussions');
        Schema::dropIfExists('gb_certificates');
        Schema::dropIfExists('gb_modules');
        Schema::dropIfExists('gb_enrollments');
        Schema::dropIfExists('gb_courses');
    }
};
