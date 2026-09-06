<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'batch_number',
        'batch_sequence_no',
        'batch_title',
        'start_date',
        'end_date',
        'class_timing',
        'class_room',
        'teacher_id',
        'capacity',
        'status',
    ];

    // Relationship: Batch belongs to Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship: Batch belongs to Teacher (User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // 🔥 ADD THIS RELATIONSHIP TO FIX ERROR
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}