@extends('store.layout.master')
@section('content')
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">

        <div class="row text-center">
            <div class="col-md-8 m-auto">
                <div class="card m-auto w-25">
                    <img src="{{ asset('storage/' . $customer->image) }}"
                        alt="{{ $customer['name_' . app()->getLocale()] }}">
                </div>
                @if ($customer->image != 'images/users/avatar.png')
                    <form action="{{ route('customer.profile.remove.image') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('delete')
                        <div class="card m-auto w-25">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-danger">remove</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <br>
        <div class="row">
            <form id="profileData" action="{{ route('customer.profile.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="col-md-8 m-auto">
                    <div class="row gy-3">
                        <div class="col-lg-6">
                            <input value="{{ $customer->first_name }}" name="first_name"
                                class="form-control form-control-lg" type="text" id="first_name"
                                placeholder="{{ __('Enter your first name') }}">
                            <small class="error text-danger" id="first_name_error">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-lg-6">
                            <input value="{{ $customer->last_name }}" name="last_name" class="form-control form-control-lg"
                                type="text" id="last_name" placeholder="{{ __('Enter your last name') }}">
                            <small class="error text-danger" id="last_name_error">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        {{-- <div class="col-lg-12">
                            <input class="form-control form-control-lg" type="email" value="{{ $customer->email }}"
                                name="email" id="email" placeholder="{{ __('Email') }}">
                            <small class="error text-danger" id="email_error">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div> --}}
                        <div class="col-lg-6">
                            <input class="form-control form-control-lg" type="text" value="{{ $customer->username }}"
                                name="username" id="username" placeholder="{{ __('Username') }}">
                            <small class="error text-danger" id="username_error">
                                @error('username')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-lg-6">
                            <input value="{{ $customer->mobile }}" name="mobile" class="form-control form-control-lg"
                                type="number" id="mobile" placeholder="{{ __('Phone number') }}">
                            <small class="error text-danger" id="mobile_error">
                                @error('mobile')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>

                        <div class="col-lg-6">
                            <input name="password" class="form-control form-control-lg" type="text" id="password"
                                placeholder="{{ __('Password') }}">
                            <small class="error text-danger" id="password_error">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-lg-6">
                            <input name="password_confirmation" class="form-control form-control-lg" type="text"
                                id="password_confirmation" placeholder="{{ __('Confirm password') }}">
                            <small class="error text-danger" id="password_confirmation_error">
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="col-lg-12">
                            <input type="file" name="image" id="image" class="form-control form-control-lg">
                            <small class="error text-danger" id="image_error">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
            </form>
            <div>
                <span onclick="profileValidation()" class="btn btn-dark mt-4 w-100">{{ __('Update') }}</span>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        let requiredMessage = "{{ __('validation.required') }}";
        let emailMessage = "{{ __('validation.email') }}";
        let chooseAddressMessage = "{{ __('Choose an address.') }}";
    </script>
@endsection
