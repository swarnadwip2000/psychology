<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payments()
    {
        $payments = UserSubscription::orderBy('id', 'desc')->paginate(12);
        return view('admin.payment.list')->with(compact('payments'));
    }

    public function paymentFetchData(Request $request)
{
    if ($request->ajax()) {
        // Retrieve sorting and search parameters from the request
        $sort_by   = $request->get('sortby');
        $sort_type = $request->get('sorttype');
        $query     = $request->get('query');
        $query     = str_replace(" ", "%", $query);

        // Start a query on the Payment model
        $paymentsQuery = UserSubscription::query();

        // If there is a search query, add where conditions on multiple columns
        if (!empty($query)) {
            $paymentsQuery->where(function($q) use ($query) {
                $q->where('payment_id', 'like', '%' . $query . '%')
                  ->orWhere('user_name', 'like', '%' . $query . '%')
                  ->orWhere('user_email', 'like', '%' . $query . '%')
                  ->orWhere('plan_name', 'like', '%' . $query . '%')
                  ->orWhere('plan_price', 'like', '%' . $query . '%')
                  ->orWhere('plan_duration', 'like', '%' . $query . '%')
                  ->orWhere('session', 'like', '%' . $query . '%')
                  ->orWhere('amount', 'like', '%' . $query . '%')
                  ->orWhere('currency', 'like', '%' . $query . '%')
                  ->orWhere('payment_method', 'like', '%' . $query . '%')
                  ->orWhere('payment_status', 'like', '%' . $query . '%');
            });
        }

        // Apply ordering and paginate the results
        $payments = $paymentsQuery->orderBy($sort_by, $sort_type)
                                    ->paginate(12);

        // Return the rendered view as a JSON response
        return response()->json([
            'data' => view('admin.payment.table', compact('payments'))->render()
        ]);
    }
}

}
