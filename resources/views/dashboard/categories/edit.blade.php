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
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($category['name_'. App::currentLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.categories.update', encrypt($category->id)) }}" method="POST"
                                                class="user" enctype="multipart/form-data">
                                                @method('patch')
                                                @csrf
                                                <div class="form-group">
                                                    <input value="{{$category->name_ar}}" type="text" name="name_ar" class="form-control form-control-user" placeholder="{{ __('Enter Name In Arabic') }}">
                                                    @error('name_ar')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input value="{{$category->name_en}}" type="text" name="name_en" class="form-control form-control-user" placeholder="{{ __('Enter Name In English') }}">
                                                    @error('name_en')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                @if ($category->parent_id != null)
                                                <div class="form-group">
                                                    {{-- parent category or this is parent --}}
                                                    <select name="parent_id" style="border-radius: 10rem;height:100%" class="form-control">
                                                        <option value="{{ $category->parent->id }}" selected>{{ $category->parent['name_'. App::currentLocale()] }}</option>
                                                        @foreach($categories as $item)
                                                        <option value="{{ $item->id }}">{{ $item['name_'. App::currentLocale()] }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('parent_id')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="fileInput" class="form-control">{{ __('Choose Image') }}</label>
                                                    <input type="file" name="image" class="custom-file-input filestyle hidden" id="fileInput">
                                                    @error('image')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="show-image-container">
                                                    <div class="show-image">
                                                        <span id="rmImage" onclick="deleteImage('{{ url('storage/'.$category->image) }}')" class="btn btn-danger btn-sm btn-rm-image hidden">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <img class="form-image" id="imageDev" src="{{ url('storage/'.$category->image) }}" alt="Your Logo"/>
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
            <!-- Outer Row -->
        @endsection
