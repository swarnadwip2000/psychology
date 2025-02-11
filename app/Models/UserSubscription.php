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
        'session',
        'free_tutorial',
        'amount',
        'membership_expiry_date',
        'currency',
        'payment_method',
        'payment_status',
    ];

    // If your membership_expiry_date is a date type, you may cast it:
    protected $casts = [
        'membership_expiry_date' => 'date',
    ];
}
