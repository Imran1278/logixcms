<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_title', 
        'home_description', 
        'home_video_url',
        'our_vision', 
        'trained_professionals_info', 
        'why_logix_title', 
        'why_logix_description', 
        'why_logix_icon',
        'educational_goals', 
        'our_mission', 
        'specific_goals', 
        'college_awards',
        'industries',
        'awards'
    ];

    protected $casts = [
        'industries' => 'array',
        'awards' => 'array',
    ];
}