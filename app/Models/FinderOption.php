<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinderOption extends Model
{
    use HasFactory;

    protected $fillable = ['finder_question_id', 'option_label', 'option_value', 'icon'];

    public function question()
    {
        return $this->belongsTo(FinderQuestion::class);
    }
}