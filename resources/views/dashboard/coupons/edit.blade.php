@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit Categories') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit Category') }}</h1>
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($coupon->code) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.coupons.update', encrypt($coupon->id)) }}" method="POST" class="user">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="code" value="{{ $coupon->code }}" class="form-control form-control-user @error('code') is-invalid @enderror" placeholder="    {{ __('Enter the code') }}">
                                                        @error('code')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="value" value="{{ $coupon->value }}" class="form-control form-control-user @error('value') is-invalid @enderror" placeholder="    {{  __('Coupon value') }}">
                                                        @error('value')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <select name="type" style="height:70%" class="form-control">
                                                            <option selected value="{{ $coupon->type }}">{{ $coupon->type }}</option>
                                                            <option value="fixed">{{ __('Fixed') }}</option>
                                                            <option value="percentage">{{ __('Percentage') }}</option>
                                                        </select>
                                                        @error('type')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="greater_than" value="{{ $coupon->greater_than }}" class="form-control form-control-user @error('greater_than') is-invalid @enderror" placeholder="    {{ __('Greater than') }}">
                                                            @error('greater_than')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="use_times" value="{{ $coupon->use_times }}" class="form-control form-control-user @error('use_times') is-invalid @enderror" placeholder="    {{ __('Use times') }}">
                                                        @error('use_times')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="used_times" value="{{ $coupon->used_times }}" class="form-control form-control-user @error('used_times') is-invalid @enderror" placeholder="    {{  __('Used times') }}">
                                                        @error('used_times')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="start_date" value="{{ date('Y-m-d', strtotime($coupon->start_date)) }}" class="form-control form-control-user @error('start_date') is-invalid @enderror" placeholder="    {{ __('Start date') }}">
                                                            @error('start_date')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="expire_date" value="{{ date('Y-m-d', strtotime($coupon->expire_date)) }}" class="form-control form-control-user @error('expire_date') is-invalid @enderror" placeholder="    {{ __('Expire date') }}">
                                                            @error('expire_date')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <textarea rows="1" style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_ar" class="form-control form-control-user
                                                        @error('description_ar') is-invalid @enderror" placeholder="{{ __('Enter Description In Arabic') }}">{{ $coupon->description_ar }}</textarea>
                                                        @error('description_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea rows="1"  style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_en" class="form-control form-control-user
                                                        @error('description_en') is-invalid @enderror" placeholder="{{ __('Enter Description In English') }}">{{ $coupon->description_en }}</textarea>
                                                        @error('description_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="checkbox" {{ $coupon->status == true ? 'checked' : '' }} value="1" name="status" class="checkbox @error('status') is-invalid @enderror">
                                                                <label><small>{{ __('Status') }}</small></label>
                                                                @error('status')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                
                                                <hr>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        {{ __('Save') }}
                                                    </button>
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
            <!-- Outer Row -->
        @endsection

