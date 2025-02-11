<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscription()
    {
        $page_title = "Subscription";
        $plans = Plan::orderBy('id', 'asc')->get();
        return view('frontend.subscription')->with(compact('page_title', 'plans'));
    }
}
