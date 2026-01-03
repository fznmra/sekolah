<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $fillable = ['student_id', 'teacher_id', 'classroom_id', 'subject_name', 'status', 'attendance_date'];
    public function student() { return $this->belongsTo(Student::class); }
}