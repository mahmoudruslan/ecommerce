@extends('dashboard.layout.master')

@section('title')
    {{ __('Add Products') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add Products') }}</h1>
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
                                            <form action="{{ route('admin.products.store') }}" method="POST"
                                                enctype="multipart/form-data" class="user">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_ar" value="{{ old('name_ar') }}"
                                                            class="form-control form-control-user @error('name_ar') is-invalid @enderror"
                                                            placeholder=" {{ __('Enter Name In Arabic') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_en" value="{{ old('name_en') }}"
                                                            class="form-control form-control-user @error('name_en') is-invalid @enderror"
                                                            placeholder=" {{ __('Enter Name In English') }}">
                                                        @error('name_en')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="price"
                                                                value="{{ old('price') }}"
                                                                class="form-control form-control-user @error('price') is-invalid @enderror"
                                                                placeholder=" {{ __('Enter Price') }}">
                                                            @error('price')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <textarea rows="1" style="background-position: 0%" type="text" name="description_ar"
                                                            value="{{ old('description_ar') }}"
                                                            class="form-control form-control-user
                                                        @error('description_ar') is-invalid @enderror"
                                                            placeholder="{{ __('Enter Description In Arabic') }}"></textarea>
                                                        @error('description_ar')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea rows="1" style="background-position: 0%" type="text" name="description_en"
                                                            value="{{ old('description_en') }}"
                                                            class="form-control form-control-user
                                                        @error('description_en') is-invalid @enderror"
                                                            placeholder="{{ __('Enter Description In English') }}"></textarea>
                                                        @error('description_en')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <select name="category_id" style="height:100%" class="form-control">
                                                            <option disabled selected>{{ __('Choose Category') }}</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->parent['name_' . App::currentLocale()] }}
                                                                    | {{ $category['name_' . App::currentLocale()] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select multiple name="tags[]" class="form-control">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->id }}">
                                                                    {{ $tag['name_' . App::currentLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('tags')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div><br>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="video_link" value="{{ old('video_link') }}"
                                                            class="form-control form-control-user @error('video_link') is-invalid @enderror"
                                                            placeholder=" {{ __('Video link') }}">
                                                        @error('video_link')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="iframe" value="{{ old('iframe') }}"
                                                            class="form-control form-control-user @error('iframe') is-invalid @enderror"
                                                            placeholder=" {{ __('Iframe') }}">
                                                        @error('iframe')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                      <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                      <input name="size_guide" type="file" class="custom-file-input @error('size_guide') is-invalid @enderror"" id="inputGroupFile01">
                                                                      <label class="custom-file-label" for="inputGroupFile01">{{__('Size guide image')}}</label>
                                                                    </div>
                                                                  </div>

                                                            @error('size_guide')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="checkbox" value="1" name="featured"
                                                                    class="checkbox @error('featured') is-invalid @enderror"
                                                                    placeholder=" {{ __('Enter Featured') }}">
                                                                <label><small>{{ __('Featured') }}</small></label>
                                                                @error('featured')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="checkbox" value="1" name="status"
                                                                    class="checkbox" placeholder="{{ __('Status') }}">
                                                                <label><small>{{ __('Active') }}</small></label>
                                                                @error('status')
                                                                    <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    @foreach ($sizes as $size)
                                                        <div class="col-md-3">
                                                            <input class="checkbox" type="checkbox"
                                                                name="sizes[{{ $size->id }}][selected]"
                                                                value="1" id="size-{{ $size->id }}">
                                                            <label
                                                                for="size-{{ $size->id }}">{{ $size->name }}</label>
                                                            <input class="form-control d-inline-block w-50" type="number"
                                                                name="sizes[{{ $size->id }}][quantity]"
                                                                min="0" disabled
                                                                placeholder="{{ __('Quantity') }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br>
                                                <input multiple type="file" name="images[]" class="file"
                                                    id="input-id" data-preview-file-type="text">
                                                <br>
                                                @error('images')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                                @error('images.0')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
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
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const quantityInput = this.parentElement.querySelector('input[type="number"]');
                    quantityInput.disabled = !this.checked;
                });
            });
        </script>
        <script>
            $("#input-id").fileinput({
                required: true,
                showUpload: false,
                showRemove: false,
            });
        </script>
    @endpush
