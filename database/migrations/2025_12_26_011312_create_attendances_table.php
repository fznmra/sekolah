<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->string('subject_name');
            $table->enum('status', ['H', 'S', 'I', 'A']);
            $table->date('attendance_date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('attendances'); }
};