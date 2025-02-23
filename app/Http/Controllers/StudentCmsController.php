<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Note;
use App\Models\Tutorial;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class StudentCmsController extends Controller
{
    // public function tutorials()
    // {
    //     $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();
    //     if ($last_user_subscription) {
    //         if ($last_user_subscription->membership_expiry_date >=  now()->toDateString() && $last_user_subscription->free_tutorial == 1) {
    //             $page_title = "Tutorials";
    //             $tutorials = Tutorial::where('class', auth()->user()->student_class)->get();
    //             return view('frontend.student.tutorials')->with(compact('tutorials', 'page_title'));
    //         } else {
    //             return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
    //         }
    //     } else {
    //         return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
    //     }
    // }


    // public function notes()
    // {
    //     $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();
    //     if ($last_user_subscription) {
    //         if ($last_user_subscription->membership_expiry_date >=  now()->toDateString() && $last_user_subscription->free_notes == 1) {
    //             $page_title = "Notes";
    //             $notes = Note::where('class', auth()->user()->student_class)->get();
    //             return view('frontend.student.notes')->with(compact('notes', 'page_title'));
    //         } else {
    //             return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
    //         }

    //     } else {
    //         return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
    //     }
    // }

    public function resources(Request $request)
    {
        $page_title = 'Resources';
        // Check subscription for both tutorials and notes
        $hasTutorialAccess = Helper::checkSubscription('free_tutorial');
        $hasNotesAccess = Helper::checkSubscription('free_notes');

        if (!$hasTutorialAccess && !$hasNotesAccess) {
            return redirect()->route('subscription')->with('error', 'You need a subscription to access these resources.');
        }

        // Fetch tutorials and notes if user has access
        $tutorials = $hasTutorialAccess ? Tutorial::where('class', auth()->user()->student_class)->get() : collect();
        $notes = $hasNotesAccess ? Note::where('class', auth()->user()->student_class)->get() : collect();

        return view('frontend.student.resources', compact('tutorials', 'page_title', 'notes', 'hasTutorialAccess', 'hasNotesAccess'));
    }
}
