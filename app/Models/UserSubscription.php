<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_name',
        'user_email',
        'plan_name',
        'plan_price',
        'plan_duration',
        'plan_week',
        'session',
        'free_tutorial',
        'free_notes',
        'amount',
        'membership_expiry_date',
        'currency',
        'payment_method',
        'payment_status',
        'membership_start_date',
    ];

    // If your membership_expiry_date is a date type, you may cast it:
    protected $casts = [
        'membership_expiry_date' => 'date',
    ];
}
