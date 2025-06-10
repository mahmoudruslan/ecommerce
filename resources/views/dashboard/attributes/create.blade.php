@extends('dashboard.layout.master')

@section('title')
    {{ __('Add attributes') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add attributes') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Add') }}</h1>
                                            </div>
                                            <form action="{{ route('admin.attributes.store') }}" method="POST" class="user">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control form-control-user @error('name_ar') is-invalid @enderror" placeholder="    {{ __('Name in arabic') }}">
                                                        @error('name_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control form-control-user @error('name_en') is-invalid @enderror" placeholder="    {{  __('Name in english') }}">
                                                        @error('name_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="type">{{__('Type')}}</label>
                                                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                                            <option value="" {{ old('type') == '' ? 'selected' : '' }}>Select Type</option>
                                                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>{{__('Text')}}</option>
                                                            <option value="watch" {{ old('type') == 'watch' ? 'selected' : '' }}>{{__('Watch')}}</option>
                                                            <option value="dropdown" {{ old('type') == 'dropdown' ? 'selected' : '' }}>{{__('Dropdown')}}</option>
                                                        </select>
                                                        @error('type')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
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
        @push('script')
        <script>
            $("#input-id").fileinput({
                required: true,
                showUpload: false,
                showRemove: false,

        });
        </script>
        @endpush

