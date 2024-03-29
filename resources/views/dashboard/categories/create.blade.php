@extends('dashboard.layout.master')

@section('title')
    {{ __('Add Categories') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add Categories') }}</h1>
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
                                            <form id="form" action="{{ route('admin.categories.store') }}" method="POST" class="user" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" name="name_ar" class="form-control form-control-user" placeholder="{{ __('Enter Name In Arabic') }}">
                                                    @error('name_ar')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="name_en" class="form-control form-control-user" placeholder="{{ __('Enter Name In English') }}">
                                                    @error('name_en')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                        {{-- parent category or this is parent --}}
                                                        <select name="parent_id" style="border-radius: 10rem;height:100%" class="form-control">
                                                            <option disabled selected>{{ __('Choose Parent Category') }} ({{ __('Optional') }})</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category['name_'. App::currentLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('parent_id')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                </div>
                                                <input type="file" name="image" class="file"  id="input-id" data-preview-file-type="text">
                                                @error('image')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                                @enderror
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

