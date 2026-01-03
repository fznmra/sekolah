<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    protected $fillable = ['classroom_id', 'parent_id', 'student_name', 'nisn'];
    public function classroom() { return $this->belongsTo(Classroom::class); }
    public function parent() { return $this->belongsTo(User::class, 'parent_id'); }
}