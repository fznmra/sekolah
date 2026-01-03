<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->string('student_name');
            $table->string('nisn')->unique();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('students'); }
};