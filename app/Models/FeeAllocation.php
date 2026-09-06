<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeAllocation extends Model
{
    protected $fillable = [
        'admission_id', 'academic_session', 'total_amount', 
        'discount_amount', 'discount_reason', 'discount_approved_by', 
        'net_payable', 'paid_amount', 'due_amount', 'status', 'created_by'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function items()
    {
        return $this->hasMany(FeeAllocationItem::class);
    }

    public function collections()
    {
        return $this->hasMany(FeeCollection::class);
    }
}