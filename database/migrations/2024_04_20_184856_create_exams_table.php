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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('user who created the exam');
            $table->string('title', 100);
            $table->text('description');
            $table->integer('total_num_of_questions');
            $table->integer('time_per_question')->comment('count in seconds');
            $table->integer('exam_total_duration')->comment('count in seconds');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->double('passing_percentage', 16, 2);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            ## Foreign references
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
