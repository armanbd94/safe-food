@if (!$payments->isEmpty())
    @foreach ($payments as $payment)
    <tr>
        <td class="text-center">{{ date(config('settings.date_format',strtotime($payment->created_at))) }}</td>
        <td class="text-right">{{ number_format($payment->amount,2) }}</td>
        <td class="text-center">{{ PAYMENT_METHOD[$payment->payment_method] }}</td>
        <td>{{ $payment->account->name }}</td>
        <td>{{ $payment->reference_no ? $payment->reference_no : '' }}</td>
        <td>{{ $payment->payment_note ? $payment->payment_note : '' }}</td>
        <td class="text-center">
            {{-- <button type="button" class="btn btn-primary btn-sm mr-3 edit-payment" data-id="{{ $payment->id }}"
                data-purchaseid="{{ $payment->purchase_id }}" data-amount="{{ $payment->amount }}" data-due="{{ $payment->purchase->grand_total - $payment->purchase->paid_amount }}"
                data-paymentmethod="{{ $payment->payment_method }}" data-accountid="{{ $payment->account_id }}"
                data-referenceno="{{ $payment->reference_no }}" data-note="{{ $payment->payment_note }}"> <i class="fas fa-edit"></i></button> --}}
            <button type="button" class="btn btn-danger btn-sm delete-payment" data-id="{{ $payment->id }}" data-purchaseid="{{ $payment->purchase_id }}"> <i class="fas fa-trash"></i></button>
        </td>
    </tr>
    @endforeach
@else
<tr>
    <td colspan="8" class="text-danger text-center">No Data Found</td>
</tr>
@endif