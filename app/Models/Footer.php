<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_description',
        'phone_number',
        'working_hours',
        'support_links',
        'learning_title',
        'map_image',
        'copyright_text',
        'bottom_phone',
        'twitter_url',
        'instagram_url',
        'facebook_url',
        'linkedin_url',
    ];

    protected $casts = [
        'support_links' => 'array',
    ];
}