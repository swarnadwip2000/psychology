<?php

namespace App\Helpers;

use App\Models\Slot;

class SlotHelper
{
    /**
     * Check if a date has available slots for a specific teacher.
     *
     * @param string $date
     * @param int $teacherId
     * @return bool
     */
    public static function hasAvailableSlots($date, $teacherId)
    {
        $time = now()->format('H:i');  // Get current time in 24-hour format
        $nowDate = now()->toDateString();

        // Query to check available slots
        $query = Slot::whereDate('slot_date', $date)
            ->where('teacher_id', $teacherId)
            ->whereDoesntHave('bookingSlot'); // Exclude booked slots

        // If checking today's date, only include future times
        if ($date == $nowDate) {
            $query->where('slot_time', '>', $time);
        }

        // Return true if available slots exist, false otherwise
        return $query->count();
    }
}
