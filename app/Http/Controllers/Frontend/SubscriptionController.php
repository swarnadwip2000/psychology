<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SubscriptionConfirmation;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class SubscriptionController extends Controller
{
    public function subscription()
    {
        $page_title = "Subscription";
        $plans = Plan::orderBy('id', 'desc')->get();
        return view('frontend.subscription')->with(compact('page_title', 'plans'));
    }

    public function payment($id)
    {

        $plan_id = $id;
        $subscription = Plan::find($plan_id);

        $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();
        if ($last_user_subscription) {
            if ($last_user_subscription->membership_expiry_date >=  now()->toDateString() && $last_user_subscription->plan_id == $plan_id  && auth()->user()->session_token > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'You have already purchased this subscription, and it is still active.');
            }
        }


        // Initialize PayPal client
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        // Create PayPal order
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success', ['plan_id' => $plan_id]),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $subscription->plan_price,
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->back()
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }




    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $subscription = Plan::find($request->plan_id);

            if (!$subscription) {
                return redirect()->route('subscription')->with('error', 'Invalid Plan selected.');
            }

            $user = auth()->user();

            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $user->id ?? null;
            $user_subscription->plan_id = $subscription->id ?? null;
            $user_subscription->user_name = $user->name ?? 'Unknown';
            $user_subscription->user_email = $user->email ?? 'Unknown';
            $user_subscription->plan_name = $subscription->plan_name ?? 'No Plan Name';
            $user_subscription->plan_price = $subscription->plan_price ?? '0.00';
            $user_subscription->plan_duration = $subscription->plan_duration ?? 0;
            $user_subscription->plan_duration_week = $subscription->plan_duration_week ?? 0;
            $user_subscription->session = $subscription->session ?? 0;
            $user_subscription->free_tutorial = $subscription->free_tutorial ?? 0;
            $user_subscription->free_notes = $subscription->free_notes ?? 0;
            $user_subscription->free_course = $subscription->free_course ?? 0;
            $user_subscription->free_documents = $subscription->free_documents ?? 0;
            $user_subscription->membership_start_date = now();
            $user_subscription->membership_expiry_date = now()->addDays($subscription->plan_duration ?? 30);

            $paymentDetails = $response['purchase_units'][0]['payments']['captures'][0] ?? [];

            $user_subscription->amount = $paymentDetails['amount']['value'] ?? $subscription->plan_price ?? '0.00';
            $user_subscription->currency = $paymentDetails['amount']['currency_code'] ?? 'USD';
            $user_subscription->payment_id = $response['id'] ?? 'N/A';
            $user_subscription->payment_method = 'PayPal';
            $user_subscription->payment_status = $response['status'] ?? 'FAILED';
            $user_subscription->payment_response = json_encode($response);

            if (!$user_subscription->user_id || !$user_subscription->plan_id || !$user_subscription->payment_id) {
                return redirect()->route('subscription')->with('error', 'Subscription data is incomplete.');
            }

            $user_subscription->save();

            $user->session_token =  $subscription->session;
            $user->save();

            // Send subscription confirmation email
            Mail::to($user->email)->send(new SubscriptionConfirmation($user_subscription));

            return redirect()->route('subscription')->with('message', 'Thank you for your subscription. Please check your email for details.');
        } else {
            return redirect()->route('subscription')->with('error', 'Subscription payment failed.');
        }
    }



    public function paypalCancel()
    {
        return redirect()->route('subscription')->with('error', 'Subscription payment cancelled.');
    }
}
