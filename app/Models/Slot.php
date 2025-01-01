<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = ["id", "teacher_id", "slot_date", "slot_time"];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function bookingSlot()
    {
        return $this->hasOne(BookingSlot::class);
    }
}
