<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'registration_no',
        'reg_sequence_no',
        'student_name',
        'father_name',
        'course_id',
        'batch_id',
        'cnic',
        'cnic_bform',
        'email',
        'mobile_contact',
        'mobile_number',
        'whatsapp_contact',
        'whatsapp_number',
        'guardian_name',
        'guardian_contact',
        'guardian_mobile',
        'gender',
        'blood_group',
        'preferred_shift',
        'shift',
        'last_qualification',
        'qualification',
        'education_details',
        'work_experience',
        'experience_details',
        'residential_address',
        'home_address',
        'total_agreed_fee',
        'status',
    ];

    protected $casts = [
        'education_details'  => 'array',
        'experience_details' => 'array',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    public function feeCollections()
    {
        return $this->hasMany(FeeCollection::class);
    }

    // New Relationships Added for Dynamic Fee Structure
    public function feeAllocations()
    {
        return $this->hasMany(FeeAllocation::class)->latest();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessors / Helper Attributes
     */
    public function getPaidFeeAttribute()
    {
        if ($this->relationLoaded('feeCollections')) {
            return $this->feeCollections->sum('amount_paid');
        }
        return $this->feeCollections()->sum('amount_paid');
    }

    public function getDueFeeAttribute()
    {
        $discount = $this->discount_amount ?? 0;
        return ($this->total_agreed_fee - $discount) - $this->paid_fee;
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'admission_id');
    }
}