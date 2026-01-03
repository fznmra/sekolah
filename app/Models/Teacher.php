<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
    protected $fillable = ['user_id', 'teacher_name', 'nip'];
    public function user() { return $this->belongsTo(User::class); }
    public function assignments() { return $this->hasMany(TeacherAssignment::class); }
}