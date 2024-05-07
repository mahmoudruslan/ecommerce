@extends('dashboard.layout.master')

@section('title')
    {{ __('Add user address') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add user address') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Add address to') }} : {{$user->fullName}}</h1>
                                            </div>
                                            <form action="{{ route('admin.user-addresses.store') }}" method="POST"
                                                class="user">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                                                        class="form-control form-control-user @error('first_name') is-invalid @enderror" 
                                                        placeholder="{{ __('First Name') }}">
                                                        @error('first_name')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                                                        class="form-control form-control-user @error('last_name') is-invalid @enderror" 
                                                        placeholder="{{ __('Last Name') }}">
                                                        @error('last_name')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="email" value="{{ old('email') }}" 
                                                        class="form-control form-control-user @error('email') is-invalid @enderror" 
                                                        placeholder="   {{ __('Email') }}">
                                                            @error('email')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input type="text" name="mobile" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('mobile') is-invalid @enderror" 
                                                        placeholder="{{ __('Phone number') }}">
                                                        @error('mobile')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="zip_code" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('zip_code') is-invalid @enderror" 
                                                        placeholder="{{ __('Enter Zip code') }}">
                                                        @error('zip_code')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="po_box" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('po_box') is-invalid @enderror" 
                                                        placeholder="{{ __('Enter Po box') }}">
                                                        @error('po_box')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <select name="governorate_id" class="form-control select-radius 
                                                        @error('governorate_id') is-invalid @enderror">
                                                            <option selected disabled>{{ __('Choose governorate') }}</option>
                                                            @foreach ($governorates as $governorate)
                                                                <option value="{{ $governorate->id }}">{{ $governorate['name_' . app()->getLocale()] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('governorate_id')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="city_id" class="form-control select-radius 
                                                        @error('city_id') is-invalid @enderror">
                                                            <option selected disabled>{{ __('Choose city') }}</option>
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}">{{ $city['name_' . app()->getLocale()] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('city_id')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div> --}}
                                                {{-- <livewire:cascading-dropdown /> --}}
                                                @livewire('cascading-dropdown', ['governorates'=> $governorates, null])
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="address_ar" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address_ar') is-invalid @enderror" 
                                                        placeholder="{{ __('Address in arabic') }}">
                                                        @error('address_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="address_en" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address_en') is-invalid @enderror" 
                                                        placeholder="{{ __('Address in english') }} ({{__('Optional')}})">
                                                        @error('address_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="address2_ar" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address2_ar') is-invalid @enderror" 
                                                        placeholder="{{ __('Second address in arabic') }} ({{__('Optional')}})">
                                                        @error('address2_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="address2_en" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address2_en') is-invalid @enderror" 
                                                        placeholder="{{ __('Second address in english') }} ({{__('Optional')}})">
                                                        @error('address2_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input type="text" name="address_title_ar" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address_title_ar') is-invalid @enderror" 
                                                        placeholder="{{ __('Address title in arabic') }}">
                                                        @error('address_title_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="address_title_en" value="{{ old('mobile') }}" 
                                                        class="form-control form-control-user @error('address_title_en') is-invalid @enderror" 
                                                        placeholder="{{ __('Address title in english') }}">
                                                        @error('address_title_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                <input value="1" class="form-check-input" type="radio" 
                                                                name="default_address" id="flexRadioDefault1" checked>
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                {{ __("Active") }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                <input value="0" class="form-check-input" type="radio" 
                                                                name="default_address" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    {{ __("Inactive") }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        @error('default_address')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    {{ __('Save') }}
                                                </button>
                                                <hr>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
