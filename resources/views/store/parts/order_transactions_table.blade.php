{{-- transactions --}}
<table class="table table-bordered text-nowrap bg-light">
    <thead style="background-color: #aaaaaa">
        <tr>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Transactions') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Payment method') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Payment result') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Transaction number') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Transaction date') }}</strong>
            </th>
        </tr>
    </thead>
    <tbody class="t-body" class="border-0">
        @foreach ($order->transactions as $transaction)
            <tr>

                <td class="p-3 align-middle border-light">
                    <p class="mb-0 small">
                        {!! $transaction->statusWithHtml() !!}
                    </p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p class="mb-0 small">
                        {{ $transaction->payment_method }}
                    </p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p class="mb-0 small">
                        {{ $transaction->payment_result ?? '--' }}
                    </p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p class="mb-0 small">
                        {{ $transaction->transaction_number ?? '--' }}
                    </p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p class="mb-0 small">
                        {{ $transaction->created_at }}
                    </p>
                </td>


            </tr>
            @if (
                $loop->last &&
                    $transaction->transaction == app\Models\OrderTransaction::FINISHED &&
                    $transaction->created_at->diffInDays(now()) < Config::get('app.order_return_days'))
                <tr>
                    <td colspan="5" class="p-3 align-middle border-light">
                        <a href="{{route('customer.orders.refund.request', $order->id)}}" class="mb-0 small">
                            <ins>{{ __('You can return order in') . ' ' . $transaction->created_at->diffInDays(now()) - Config::get('app.order_return_days') . ' ' . __('Days') }}
                            </ins>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach

    </tbody>
</table>
