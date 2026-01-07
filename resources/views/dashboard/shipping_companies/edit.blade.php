@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit shipping company') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit shipping company') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($shipping_company['name_'. App::currentLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.shipping-companies.update', encrypt($shipping_company->id)) }}" method="POST"
                                                class="user" enctype="multipart/form-data">
                                                @csrf
                                                @method("Patch")
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_ar" value="{{ $shipping_company->name_ar }}" class="form-control form-control-user @error('name_ar') is-invalid @enderror" placeholder="{{ __('Name in arabic') }}">
                                                        @error('name_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_en" value="{{ $shipping_company->name_en }}" class="form-control form-control-user @error('name_en') is-invalid @enderror" placeholder="{{ __('Name in english') }}">
                                                        @error('name_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="description_ar" value="{{ $shipping_company->description_ar }}" class="form-control form-control-user @error('description_ar') is-invalid @enderror" placeholder="{{ __('Description in arabic') }}">
                                                        @error('description_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="description_en" value="{{ $shipping_company->description_en }}" class="form-control form-control-user @error('description_en') is-invalid @enderror" placeholder="{{ __('Description in english') }}">
                                                        @error('description_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="code" value="{{ $shipping_company->code }}" class="form-control form-control-user @error('code') is-invalid @enderror" placeholder="   {{ __('Code') }}">
                                                            @error('code')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="coast" value="{{ $shipping_company->coast }}" class="form-control form-control-user @error('coast') is-invalid @enderror" placeholder="   {{ __('Coast') }}">
                                                            @error('coast')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <select name="fast" class="form-control select-radius
                                                            @error('fast') is-invalid @enderror">
                                                            <option selected value="{{ $shipping_company->fast }}">{{ __($shipping_company->fast()) }}</option>
                                                            <option value="1" >{{ __('Fast') }}</option>
                                                            <option value="0" >{{ __('Normal') }}</option>
                                                        </select>
                                                        @error('fast')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="status" class="form-control select-radius
                                                            @error('status') is-invalid @enderror">
                                                            <option selected value="{{ $shipping_company->status }}">{{ __($shipping_company->label()) }}</option>
                                                            <option value="1" >{{ __('Active') }}</option>
                                                            <option value="0" >{{ __('Inactive') }}</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <select multiple name="governorates[]" class="form-control">
                                                            @foreach($governorates as $governorate)
                                                                <option {{ in_array($governorate->id, $shipping_company->governorates->pluck('id')->toArray()) ? 'selected' : ''}}
                                                                value="{{ $governorate->id }}">{{ $governorate['name_'. App::currentLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('governorates')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <hr>
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
