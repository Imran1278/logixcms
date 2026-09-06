<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_no',
        'admission_id',
        'fee_allocation_id', // Multi-head allocation linking ke liye add kiya gaya hai
        'amount_paid',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'received_by',
        'remarks'
    ];

    /**
     * Relationship: Collection belongs to an Admission
     */
    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    /**
     * Relationship: Collection belongs to a specific Fee Allocation
     */
    public function allocation()
    {
        return $this->belongsTo(FeeAllocation::class, 'fee_allocation_id');
    }
}