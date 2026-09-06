<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['certificate_no', 'admission_id', 'issue_date', 'grade', 'issued_by'];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}