<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiries';

    protected $fillable = [
        'inquiry_date',
        'student_name',
        'mobile_number',
        'whatsapp_number',
        'father_mobile',
        'email',
        'cnic',
        'course_id',
        'source',
        'status',
        'followed_social_media',
        'ai_lead_score',
        'remarks',
        'assigned_counselor_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withDefault([
            'course_name' => 'General Inquiry',
            'title'       => 'General Inquiry',
            'course_code' => 'GEN'
        ]);
    }
}