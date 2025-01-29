<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    // Static function to convert datetime to user's timezone
    public static function convertToUserDate($datetime, $userTimezone)
    {
        // Assuming $datetime is a string like 'Y-m-d H:i:s' and $userTimezone is a valid timezone
        return Carbon::parse($datetime)
            ->setTimezone($userTimezone) // Convert to user's timezone
            ->format('m-d-Y'); // Format as desired
    }

    public static function convertToUserTime($datetime, $userTimezone)
    {
        // Assuming $datetime is a string like 'Y-m-d H:i:s' and $userTimezone is a valid timezone
        return Carbon::parse($datetime)
            ->setTimezone($userTimezone) // Convert to user's timezone
            ->format('H:i'); // Format as desired
    }
}
