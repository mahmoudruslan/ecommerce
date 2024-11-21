@extends('dashboard.layout.master')
@section('content')
    @php
        $lang = app()->getLocale();
    @endphp
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex">
                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Order details') }}</h4>
                        <div class="ml-auto">
                            <div class="form-row align-items-center">
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" href="#" data-toggle="modal" data-target="#orderStatusModal{{$order->id}}"
                                                class="input-group-text">
                                                {{ __('Update order status') }}
                                            </button>
                                        </div>
                                        <select name="status" class="form-control" style="outline-style: none">
                                            <option selected disabled>{{ __('Choose status') }}</option>
                                            {{-- onchange="this.form.submit()" --}}

                                            @foreach ($available_order_status as $status_key => $status_value)
                                                <option value="{{ $status_key }}">
                                                    {{ __($status_value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('dashboard.modals.confirm_order_status')
                                </form>
                            </div>

                            <!-- Order Status Modal-->


                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('Reference ID') }}</th>
                                            <td>{{ $order->ref_id }}</td>
                                            <th>{{ __('Customer') }}</th>
                                            <td>
                                                @if ($order->user_id != null)
                                                    <a href="{{ route('admin.users.show', $order->user_id) }}">
                                                        {{ $order->customer->fullName }}
                                                    </a>
                                                @else
                                                    {{ $order->orderAddress->fullName }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Address') }}</th>
                                            <td>
                                                @if ($order->user_id != null)
                                                    <a
                                                        href="{{ route('admin.user-addresses.show', $order->userAddress->id) }}">
                                                        {{ $order->userAddress->address }}
                                                    </a>
                                                @else
                                                    {{ $order->orderAddress->address }}
                                                @endif
                                            </td>
                                            <th>{{ __('Customer type') }}</th>
                                            <td>
                                                @if ($order->user_id != null)
                                                    {{ __('Authenticated') }}
                                                @else
                                                    {{ __('Guest') }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>{{ __('Created at:') }}</th>
                                            <td>{{ $order->created_at }}</td>
                                            <th>{{ __('Status') }}</th>
                                            <td>{!! $order->statusWithHtml() !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('Subtotal') }}</th>
                                            <td>
                                                {{ $order->sub_total }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Discount') }}</th>
                                            <td>
                                                {{ $order->discount ?? '--' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Shipping') }}</th>
                                            <td>
                                                {{ $order->shipping }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Total') }}</th>
                                            <td>
                                                {{ $order->total }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Products') }}</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        {{ __('Product') }}
                                    </th>
                                    <th>
                                        {{ __('Price') }}
                                    </th>
                                    <th>
                                        {{ __('Quantity') }}
                                    </th>
                                    <th>
                                        {{ __('Total') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>
                                            <a class="reset-anchor animsition-link"
                                                href="{{ route('customer.product.detail', $product->slug) }}">
                                                {{ $product['name_' . $lang] }}
                                            </a>
                                        </td>
                                        <td>
                                            <p id="price-{{ $product->id }}" class="mb-0 small">
                                                {{ $product->price }}</p>
                                        </td>
                                        <td>
                                            <p id="price-{{ $product->id }}" class="mb-0 small">
                                                {{ $product->pivot->quantity }}</p>
                                        </td>
                                        <td>
                                            <p id="total-quantity-{{ $product->id }}" class="mb-0 small">
                                                {{ $product->pivot->quantity * $product->price }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Transactions') }}</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        {{ __('Transactions') }}
                                    </th>
                                    <th>
                                        {{ __('Payment method') }}
                                    </th>
                                    <th>
                                        {{ __('Payment result') }}
                                    </th>
                                    <th>
                                        {{ __('Transaction number') }}
                                    </th>
                                    <th>
                                        {{ __('Transaction date') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->transactions as $transaction)
                                    <tr>
                                        <td>
                                            {!! $transaction->statusWithHtml() !!}
                                        </td>
                                        <td>
                                            {{ $transaction->payment_method }}
                                        </td>
                                        <td>
                                            {{ $transaction->payment_result ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $transaction->transaction_number ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $transaction->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            {{ __('No transactions found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        @endsection
