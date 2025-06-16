@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit attribute values') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit attribute value') }}</h1>
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($attributeValue['value_' . app()->getLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.attribute-values.update', $attributeValue->id) }}" method="POST" class="user">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="value_ar" value="{{ $attributeValue->value_ar }}" class="form-control form-control-user @error('value_ar') is-invalid @enderror" placeholder="    {{ __('Name in arabic') }}">
                                                        @error('value_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="value_en" value="{{ $attributeValue->value_en }}" class="form-control form-control-user @error('value_en') is-invalid @enderror" placeholder="    {{  __('Name in english') }}">
                                                        @error('value_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="type">{{__('Attribute')}}</label>
                                                        <select class="form-control @error('attribute_id') is-invalid @enderror" id="attribute_id" name="attribute_id">
                                                            <option value="{{$attributeValue->attribute_id}}" {{ old('attribute_id', $attributeValue->attribute_id ?? '') == '' ? 'selected' : '' }}>{{$attributeValue->attribute['name_'. app()->getLocale()] }}</option>
                                                            @foreach($attributes as $attribute)
                                                                <option value="{{ $attribute->id }}" {{ old('attribute_id', $attribute->attribute_id ?? '') == $attribute->id ? 'selected' : '' }}>{{ $attribute['name_' . app()->getLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('attribute_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
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

