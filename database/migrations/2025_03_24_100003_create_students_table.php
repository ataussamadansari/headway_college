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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('college_register_no')->unique();
            $table->string('control_no')->unique();
            $table->date('registration_date');
            $table->foreignId('course_id')->constrained('courses')->onDelete('restrict');
            $table->foreignId('session_id')->constrained('academic_sessions')->onDelete('restrict');
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('religion')->nullable();
            $table->string('category')->nullable();
            $table->boolean('domicile_up')->default(false);
            $table->boolean('is_handicap')->default(false);
            $table->date('dob');
            $table->string('mobile', 10);
            $table->text('address');
            $table->string('pincode', 6);
            $table->string('photo_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamps();
            $table->index('college_register_no');
            $table->index('control_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
