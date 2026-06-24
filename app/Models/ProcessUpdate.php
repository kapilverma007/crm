<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessUpdate extends Model
{
    protected $fillable = [
        'customer_id',
        'stage1_registration',
        'stage1_payment',
        'stage1_date',
        'stage2_jol',
        'stage2_payment',
        'stage2_date',
        'stage3_wp',
        'stage3_payment',
        'stage3_date',
        'stage4_appointment',
        'stage4_payment',
        'stage4_date',
        'stage5_visa',
        'stage5_payment',
        'stage5_date',
    ];

    protected $casts = [
        'stage1_registration' => 'boolean',
        'stage1_payment' => 'boolean',
        'stage1_date' => 'date',
        'stage2_jol' => 'boolean',
        'stage2_payment' => 'boolean',
        'stage2_date' => 'date',
        'stage3_wp' => 'boolean',
        'stage3_payment' => 'boolean',
        'stage3_date' => 'date',
        'stage4_appointment' => 'boolean',
        'stage4_payment' => 'boolean',
        'stage4_date' => 'date',
        'stage5_visa' => 'boolean',
        'stage5_payment' => 'boolean',
        'stage5_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
