<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [ "teacher_id", "student_id", "date", 'time', "zoom_id", "zoom_response", 'slot_id', 'meeting_status', 'meeting_start_time', 'meeting_end_time'];

    public function teacher()
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    // Define the relationship: A session belongs to a student
    public function student()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function slot()
    {
        return $this->hasOne(Slot::class, 'id', 'slot_id');
    }
}
