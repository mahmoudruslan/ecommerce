@extends('store.layout.master')
@section('content')
    @php
        $lang = app()->getLocale();

    @endphp
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('Profile') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.profile') }}">{{ __('Profile') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Addresses') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row">
            <button  href="#add-address" data-bs-toggle="modal" class="m-auto btn btn-dark w-25">
                <strong>{{__('Add new address')}}</strong>
                <i class="fas fa-plus"aria-hidden="true"></i>
            </button>
        </div>
        @include('store.modals.add_customer_address')
        <div class="row text-center">
            @foreach ($addresses as $address)
                <div class="col-md-3 my-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title d-inline-block">{{ $address->first_name }} {{ $address->last_name }}</h5>
                            @if ($address->default_address == 1)
                                <span><small class="text-muted bold mx-1">default</small></span>
                            @endif
                            <p class="card-text">{{ $address->address }}</p>
                            <p class="card-text">{{ $address->governorate['name_' . $lang] }}</p>
                            <p class="card-text">{{ $address->city['name_' . $lang] }}</p>

                            <button href="#edit-address{{$address->id}}" data-bs-toggle="modal"
                                class="btn card-link out-line btn-light">{{ __('Edit') }}</button>
                            <form class="d-inline-block"
                                action="{{ route('customer.profile.address.remove', encrypt($address->id)) }}"
                                method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn card-link btn-light">{{ __('Remove') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @include('store.modals.edit_customer_address')
            @endforeach
        </div>
        <br>


    </section>
@endsection
@section('js')
    <script>
        let requiredMessage = "{{ __('validation.required') }}";
        let emailMessage = "{{ __('validation.email') }}";
        let chooseAddressMessage = "{{ __('Choose an address.') }}";
    </script>
@endsection
