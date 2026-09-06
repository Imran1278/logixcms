<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeAllocationItem extends Model
{
    protected $fillable = [
        'fee_allocation_id', 'fee_head_id', 'amount', 
        'frequency', 'due_date', 'late_fine', 'waived_amount'
    ];

    // Alias for feeHead relationship used in views
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class, 'fee_head_id');
    }

    public function head()
    {
        return $this->belongsTo(FeeHead::class, 'fee_head_id');
    }
}