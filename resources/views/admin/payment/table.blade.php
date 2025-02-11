@if (count($payments) > 0)
@foreach ($payments as $payment)
    <tr>
        <td>{{ $payment->payment_id ?? 'N/A' }}</td>
        <td>{{ $payment->user_name ?? 'N/A' }}</td>
        <td>{{ $payment->user_email ?? 'N/A' }}</td>
        <td>{{ $payment->plan_name ?? 'N/A' }}</td>
        <td>{{ $payment->plan_price ?? 'N/A' }} {{ $payment->currency ?? 'N/A' }}</td>
        <td>{{ $payment->plan_duration ?? 'N/A' }}</td>
        <td>{{ $payment->session ?? 'N/A' }}</td>
        <td>
            @if ($payment->free_tutorial)
                <span class="badge badge-success">Yes</span>
            @else
                <span class="badge badge-danger">No</span>
            @endif
        </td>
        <td>{{ $payment->amount ?? 'N/A' }}</td>
        <td>
            {{ $payment->membership_expiry_date ? \Carbon\Carbon::parse($payment->membership_expiry_date)->format('d M Y') : 'N/A' }}
        </td>
        <td>{{ $payment->currency ?? 'N/A' }}</td>
        <td>{{ $payment->payment_method ?? 'N/A' }}</td>
    </tr>
@endforeach

{{-- Pagination --}}
@if ($payments->hasPages())
    <tr>
        <td colspan="12">
            <div class="d-flex justify-content-center">
                {!! $payments->links() !!}
            </div>
        </td>
    </tr>
@endif
@else
<tr>
    <td colspan="12" class="text-center">No Data Found</td>
</tr>
@endif
