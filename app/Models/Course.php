<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'duration',
        'duration_type',
        'timing',
        'seats',
        'standard_fee',
        'registration_fee',
        'certification_fee',
        'image',
        'description',
        'objectives',
        'eligibility',
        'reviews',
        'status',
    ];

    // Relationship: Course has many Batches
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    // Relationship: Course has many Inquiries
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}