@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit Products') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit Products') }}</h1>
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <div style="display: block;width: 100%" class="card-header py-3">
                                    @can('update-products')
                                        <a  href="{{route('admin.products.variants.create', $product)}}" class="btn btn-primary">
                                            {{__('Add variants')}}
                                            <i class="fa fa-plus plus"></i>
                                        </a>
                                    @endcan
                                </div>
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} :
                                                    {{ __($product['name_' . App::currentLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.update', encrypt($product->id)) }}"
                                                method="POST" class="user" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Name In Arabic') }}</small></label>
                                                        <input type="text" name="name_ar" value="{{ $product->name_ar }}"
                                                            class="form-control form-control-user @error('name_ar') is-invalid @enderror"
                                                            placeholder="    {{ __('Enter Name In Arabic') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Name In English') }}</small></label>
                                                        <input type="text" name="name_en"
                                                            value="{{ $product->name_en }}"
                                                            class="form-control form-control-user @error('name_en') is-invalid @enderror"
                                                            placeholder="    {{ __('Enter Name In English') }}">
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
                                                            <label><small>{{ __('Enter Price') }}</small></label>
                                                            <input type="text" name="price"
                                                                value="{{ $product->price }}"
                                                                class="form-control form-control-user @error('price') is-invalid @enderror"
                                                                placeholder="    {{ __('Enter Price') }}">
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
                                                        <label><small>{{ __('Enter Description In Arabic') }}</small></label>
                                                        <textarea style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text"
                                                            name="description_ar" value="{{ old('description_ar') }}"
                                                            class="form-control form-control-user
                                                        @error('description_ar') is-invalid @enderror"
                                                            placeholder="   {{ __('Enter Description In Arabic') }}">{{ $product->description_ar }}</textarea>
                                                        @error('description_ar')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Description In English') }}</small></label>
                                                        <textarea style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text"
                                                            name="description_en"
                                                            class="form-control form-control-user
                                                        @error('description_en') is-invalid @enderror"
                                                            placeholder="   {{ __('Enter Description In English') }}">{{ $product->description_en }}</textarea>
                                                        @error('description_en')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Choose Category') }}</small></label>
                                                        <select style="height: 103px" name="category_id"
                                                            class="form-control">
                                                            <option value="{{ $product->category->id }}" selected>
                                                                {{ $product->category->parent['name_' . App::currentLocale()] }}
                                                                | {{ $product->category['name_' . App::currentLocale()] }}
                                                            </option>
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
                                                        <label><small>{{ __('Choose tags') }}</small></label>
                                                        <select multiple name="tags[]" class="form-control">
                                                            @foreach ($tags as $tag)
                                                                <option
                                                                    {{ in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'selected' : '' }}
                                                                    value="{{ $tag->id }}">
                                                                    {{ $tag['name_' . App::currentLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Video link') }}</small></label>
                                                        <input type="text" name="video_link"
                                                            value="{{ $product->video_link }}"
                                                            class="form-control form-control-user @error('video_link') is-invalid @enderror"
                                                            placeholder="    {{ __('Video link') }}">
                                                        @error('video_link')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Iframe') }}</small></label>
                                                        <input type="text" name="iframe" value="{{ $product->iframe }}"
                                                            class="form-control form-control-user @error('iframe') is-invalid @enderror"
                                                            placeholder="    {{ __('Iframe') }}">
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
                                                                    <input name="size_guide" type="file"
                                                                        class="custom-file-input @error('size_guide') is-invalid @enderror"
                                                                        id="inputGroupFile01">
                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">{{ __('Size guide image') }}</label>
                                                                </div>
                                                            </div>

                                                            @error('size_guide')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input {{ $product->featured == true ? 'checked' : '' }}
                                                            type="checkbox" value="1" name="featured"
                                                            class="checkbox @error('featured') is-invalid @enderror"
                                                            placeholder="    {{ __('Enter Featured') }}">
                                                        <label><small>{{ __('Featured') }}</small></label>
                                                        @error('featured')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input {{ $product->status == true ? 'checked' : '' }}
                                                            type="checkbox" value="1" name="status"
                                                            class="checkbox" placeholder="{{ __('Status') }}">
                                                        <label><small>{{ __('Active') }}</small></label>
                                                        @error('status')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    @foreach ($sizes as $size)
                                                        <div class="col-md-3">
                                                            <input class="checkbox" type="checkbox"
                                                                name="sizes[{{ $size->id }}][selected]"
                                                                value="1" id="size-{{ $size->id }}"
                                                                {{ $product->sizes->contains($size->id) ? 'checked' : '' }}>
                                                            <label
                                                                for="size-{{ $size->id }}">{{ $size->name }}</label>

                                                            <input class="form-control d-inline-block w-50" type="number"
                                                                name="sizes[{{ $size->id }}][quantity]"
                                                                min="0" placeholder="الكمية"
                                                                value="{{ $product->sizes->contains($size->id) ? $product->sizes->find($size->id)->pivot->quantity : '' }}"
                                                                {{ $product->sizes->contains($size->id) ? '' : 'disabled' }}>

                                                        </div>
                                                    @endforeach
                                                </div>
                                                {{-- </div> --}}
                                                <br>

                                                <div class="show-image-container">
                                                    <div id="parent" class="show-image">
                                                    </div>
                                                </div>
                                                <input multiple type="file" name="images[]" class="file"
                                                    id="input-id" data-preview-file-type="text">
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
            showUpload: false,
            showRemove: false,
            // required: true,
            'initialPreview': [
                @if ($product->media()->count() > 0)
                    @foreach ($product->media as $media)
                        "{{ asset('storage/' . $media->file_name) }}",
                    @endforeach
                @endif

            ],
            'initialPreviewFileType': 'image',
            'initialPreviewAsData': true,
            'overviewInitial': false,
            'initialPreviewConfig': [
                @if ($product->media()->count() > 0)
                    @foreach ($product->media as $media)
                        {
                            size: '1111',
                            width: '120px',
                            url: "{{ route('admin.products.remove-image', ['product_id' => $product->id, 'media_id' => $media->id, '_token' => csrf_token()]) }}",
                            key: {{ $product->id }},
                        },
                    @endforeach
                @endif

            ],
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
        });
    </script>
@endpush
