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
        Schema::create('educational_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('qualification_type', ['highschool', 'intermediate', 'ug']);
            $table->string('board_university');
            $table->string('stream');
            $table->integer('year_of_completion');
            $table->string('roll_number');
            $table->integer('max_marks');
            $table->integer('obtained_marks');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_qualifications');
    }
};
