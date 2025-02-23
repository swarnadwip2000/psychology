<?php

namespace App\Helpers;

use App\Models\UserSubscription;

class Helper
{

    public static function expireTo($date)
    {
        // how many day left to expire
        $now = time();
        $your_date = strtotime($date);
        $datediff = $your_date - $now;
        $days = floor($datediff / (60 * 60 * 24));
        return $days;
    }

    public static function checkSubscriptionFree()
    {
        $count = UserSubscription::where('user_id', auth()->id())->where('plan_price', 0)->count();
        return $count;
    }

    public static function checkSubscription($type)
    {
        $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();
        if ($last_user_subscription) {
            if ($type == 'free_notes') {
                if ($last_user_subscription->membership_expiry_date >=  now()->toDateString() && $last_user_subscription->free_notes == 1) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($type == 'free_tutorial') {
                if ($last_user_subscription->membership_expiry_date >=  now()->toDateString() && $last_user_subscription->free_tutorial == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getActiveSubscriptionPlanId()
    {
        $last_user_subscription = UserSubscription::where('user_id', auth()->id())
            ->where('membership_expiry_date', '>=', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        return $last_user_subscription ? $last_user_subscription->plan_id : null;
    }
}
