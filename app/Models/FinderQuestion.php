<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinderQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'icon', 'field_name', 'step_number'];

    public function options()
    {
        return $table = $this->hasMany(FinderOption::class);
    }
}