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
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($product['name_'. App::currentLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.update', encrypt($product->id)) }}" method="POST" class="user">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Name In Arabic') }}</small></label>
                                                        <input type="text" name="name_ar" value="{{ $product->name_ar }}" class="form-control form-control-user @error('name_ar') is-invalid @enderror" placeholder="    {{ __('Enter Name In Arabic') }}">
                                                        @error('name_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Name In English') }}</small></label>
                                                        <input type="text" name="name_en" value="{{ $product->name_en }}" class="form-control form-control-user @error('name_en') is-invalid @enderror" placeholder="    {{  __('Enter Name In English') }}">
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
                                                            <input type="text" name="price" value="{{ $product->price }}" class="form-control form-control-user @error('price') is-invalid @enderror" placeholder="    {{ __('Enter Price') }}">
                                                            @error('price')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label><small>{{ __('Enter Quantity') }}</small></label>
                                                            <input type="text" name="quantity" value="{{ $product->quantity }}" class="form-control form-control-user @error('quantity') is-invalid @enderror" placeholder="    {{ __('Enter Quantity') }}">
                                                            @error('quantity')
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
                                                        <textarea style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_ar" value="{{ old('description_ar') }}" class="form-control form-control-user
                                                        @error('description_ar') is-invalid @enderror" placeholder="   {{ __('Enter Description In Arabic') }}">{{ $product->description_ar }}</textarea>
                                                        @error('description_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><small>{{ __('Enter Description In English') }}</small></label>
                                                        <textarea  style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_en" class="form-control form-control-user
                                                        @error('description_en') is-invalid @enderror" placeholder="   {{ __('Enter Description In English') }}">{{ $product->description_en }}</textarea>
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
                                                        <select name="category_id"  class="form-control">
                                                            <option value="{{ $product->category->id }}" selected>{{ $product->category->parent['name_'. App::currentLocale()] }} | {{ $product->category['name_'. App::currentLocale()] }}</option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->parent['name_'. App::currentLocale()] }} | {{ $category['name_'. App::currentLocale()] }}</option>
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
                                                        <select multiple name="tags"  class="form-control">
                                                            <option value="{{ $product->category->id }}" selected>{{ $product->category->parent['name_'. App::currentLocale()] }} | {{ $product->category['name_'. App::currentLocale()] }}</option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->parent['name_'. App::currentLocale()] }} | {{ $category['name_'. App::currentLocale()] }}</option>
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
                                                    <div class="col-md-3">
                                                        <input type="checkbox" value="1" name="featured" class="checkbox @error('featured') is-invalid @enderror" placeholder="    {{ __('Enter Featured') }}">
                                                        <label><small>{{ __('Featured') }}</small></label>
                                                        @error('featured')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                        <div class="col-md-3">
                                                        <input type="checkbox" value="1" name="status" class="checkbox" placeholder="{{ __('Status') }}">
                                                        <label><small>{{ __('Active') }}</small></label>
                                                        @error('status')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div><br>
                                                <div class="show-image-container">
                                                    <div id="parent" class="show-image" >

                                                    </div>
                                                </div>
                                                <input type="file" name="image" class="file"  id="input-id" data-preview-file-type="text">
                                                @error('image')
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
            <!-- Outer Row -->
        @endsection
        @push('script')
        <script>
                $("#input-id").fileinput({
                    showUpload: false,
                    showRemove: false,
                    required: true,
                    'initialPreview': [
                        "{{ asset('storage/' . $product->firstMedia->file_name) }}",
                ],
                'initialPreviewFileType':'image',
                'initialPreviewAsData':true,
                'initialPreviewConfig':[{
                    // caption: "{{ $category->image }}",
                    size: '1111',
                    width: '120px',
                    url: "{{ route('admin.products.remove-image', [$product->id , '_token' => csrf_token()]) }}",
                    key: {{ $product->id }},
                }]
            });
        </script>
    @endpush

