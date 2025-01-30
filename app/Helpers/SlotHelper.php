<?php

namespace App\Helpers;

use App\Models\Slot;
use Carbon\Carbon;

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
        $my_time_zone = auth()->user()->time_zone; // User's timezone
        $current_time_in_user_timezone = Carbon::now($my_time_zone)->format('H:i'); // Current time in user's timezone
        $current_date_in_user_timezone = Carbon::now($my_time_zone)->format('Y-m-d');

        // Convert user-provided date to UTC for database query
        $slot_date_utc = $date;

        // Query to check available slots
        $slots = Slot::where('teacher_id', $teacherId)
            ->whereDoesntHave('bookingSlot') // Exclude booked slots
            ->get();

        // Filter slots by converting slot_time to user's timezone
        $available_slots = $slots->filter(function ($slot) use ($my_time_zone, $current_time_in_user_timezone, $current_date_in_user_timezone, $slot_date_utc) {
            // Convert slot date and time from UTC to user's timezone
            $slot_date_time = Carbon::parse($slot->slot_date . ' ' . $slot->slot_time, $slot->teacher->time_zone)
                ->setTimezone($my_time_zone);

            // If checking today's date, only include future slots
            if ($slot_date_time->format('Y-m-d') == $slot_date_utc) {

                if ($slot_date_time->format('Y-m-d') == $current_date_in_user_timezone) {
                    return  $slot_date_time->format('H:i') > $current_time_in_user_timezone;
                }
                return true;
            }

            // If future date, always available
        });

        // Return true if available slots exist, false otherwise
        return $available_slots->isNotEmpty();
    }

    public static function formatDateTimeForUser($dateTime, $userTimeZone, $dateFormat = 'm-d-Y', $timeFormat = 'H:i')
    {
        if (!$dateTime) {
            return 'N/A'; // If no datetime, return 'N/A'
        }

        // Convert the datetime to the user's timezone
        $dateInUserTimezone = Carbon::parse($dateTime)->setTimezone($userTimeZone);

        // Format the date and time
        $formattedDate = $dateInUserTimezone->format($dateFormat);
        $formattedTime = $dateInUserTimezone->format($timeFormat);

        return $formattedDate . ' ' . $formattedTime;
    }
}
