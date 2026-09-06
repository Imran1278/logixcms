<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingNews extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'news_date', 'description', 'status'];
    protected $casts = ['news_date' => 'date'];
}