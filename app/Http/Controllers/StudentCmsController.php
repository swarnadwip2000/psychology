<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tutorial;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class StudentCmsController extends Controller
{
    public function tutorials()
    {
        $last_user_subscription = UserSubscription::where('user_id', auth()->id())->whereDate('membership_expiry_date', '>=', now()->toDateString())->where('free_tutorial', 1)->orderBy('id', 'desc')->first();
        if ($last_user_subscription) {
            $page_title = "Tutorials";
            $tutorials = Tutorial::where('class', auth()->user()->student_class)->paginate(16);
            return view('frontend.student.tutorials')->with(compact('tutorials', 'page_title'));
        } else {
            return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
        }
    }


    public function notes()
    {
        $last_user_subscription = UserSubscription::where('user_id', auth()->id())->whereDate('membership_expiry_date', '>=', now()->toDateString())->where('free_notes', 1)->orderBy('id', 'desc')->first();
        if ($last_user_subscription) {
            $page_title = "Notes";
            $notes = Note::where('class', auth()->user()->student_class)->paginate(16);
            return view('frontend.student.notes')->with(compact('notes', 'page_title'));
        } else {
            return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
        }
    }

}
