<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model {
    protected $fillable = ['student_id', 'teacher_id', 'subject_id', 'category', 'score'];
    public function student() { return $this->belongsTo(Student::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
}