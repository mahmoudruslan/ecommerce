<table class="bg-light table table-bordered text-nowrap">
    <thead style="background-color: #aaaaaa">
        <tr>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Product') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Price') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Quantity') }}</strong>
            </th>
            <th class="border-0 p-3" scope="col"> <strong
                    class="text-sm text-uppercase">{{ __('Total') }}</strong>
            </th>
        </tr>
    </thead>
    <tbody class="t-body" class="border-0">
        @foreach ($order->products as $product)
            <tr>
                <td class="p-3 align-middle border-light">
                    <a class="reset-anchor animsition-link"
                        href="{{ route('customer.product.detail', $product->slug) }}">
                        {{ $product['name_' . $lang] }}
                    </a>
                </td>
                <td class="p-3 align-middle border-light">
                    <p id="price-{{ $product->id }}" class="mb-0 small">
                        {{ $product->price }}</p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p id="price-{{ $product->id }}" class="mb-0 small">
                        {{ $product->pivot->quantity }}</p>
                </td>
                <td class="p-3 align-middle border-light">
                    <p id="total-quantity-{{ $product->id }}"
                        class="mb-0 small">
                        {{ $product->pivot->quantity * $product->price }}</p>
                </td>
            </tr>
        @endforeach
        <tr class="bg-info">
            <th scope="row">{{__('Shipping')}}</th>
            <td>{{$order->shipping}}</td>
            <th scope="row">{{__('Discount')}}</th>
            <td>{{$order->discount ?? '--'}}</td>
        </tr>
        <tr class="bg-info">
            <th scope="row">{{__('Subtotal')}}</th>
            <td>{{$order->sub_total}}</td>
            <th scope="row">{{__('Total')}}</th>
            <td>{{$order->total}}</td>
        </tr>
    </tbody>
</table>
