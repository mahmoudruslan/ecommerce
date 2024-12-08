@extends('store.layout.master')
@section('content')
    <!-- HERO SECTION-->

    @php
        $lang = app()->getLocale();
        $current_url = url()->current();
    @endphp
    <section class="py-5 bg-light">

        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('Shop') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="{{ route('customer.store') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Shop') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container p-0">
            <div class="row">
                {{-- livewire alert --}}
                <div class="livewire-alert-success  fade show" role="alert"></div>
                <!-- SHOP SIDEBAR-->
                <div class="col-lg-3 order-2 order-lg-1">
                    <h5 class="text-uppercase mb-4">{{ __('Categories') }}</h5>
                    @forelse ($sopping_categories_menu as $parent_category)
                        <div class="py-2 px-4 mb-3 bg-dark text-white"><strong class="small text-uppercase fw-bold">
                                {{ $parent_category['name_' . $lang] }}</strong></div>
                        <ul class="list-unstyled small text-muted ps-lg-4 font-weight-normal">
                            @forelse ($parent_category->appearChildren as $category)
                                <li
                                    class="mb-2  {{ strpos($current_url, $parent_category->slug) && strpos($current_url, $category->slug) && strpos($current_url, 'category') == true ? ' active-sub-category' : '' }}">
                                    <a class="reset-anchor"
                                        href="{{ route('customer.shopping', ['category', $parent_category->slug, $category->slug]) }}">
                                        <h6>{{ $category['name_' . $lang] }}</h6>
                                    </a>
                                </li>
                            @empty
                                <li class="mb-2">
                                    {{ __('Not found sub categories') }}</li>
                            @endforelse
                        </ul>
                    @empty
                        <div class="py-2 px-4 mb-3"><strong
                                class="small text-uppercase fw-bold">{{ __('Not found categories') }}
                            </strong></div>
                    @endforelse
                    <h5 class="text-uppercase mb-4">{{ __('Tags') }}</h5>
                    <ul class="list-unstyled small text-muted ps-lg-4 font-weight-normal">
                        @forelse ($sopping_tags_menu as $tag)
                            <li
                                class="mb-2 {{ strpos($current_url, $tag->slug) && strpos($current_url, 'tag') == true ? ' active-sub-category' : '' }}">
                                <a class="reset-anchor" href="{{ route('customer.shopping', ['tag', $tag->slug]) }}">
                                    <h6>{{ $tag['name_' . $lang] }}</h6>

                                </a>
                            </li>
                        @empty
                            <li class="mb-2"><a class="reset-anchor" href="#!">{{ __('Not found tags') }}</a></li>
                        @endforelse
                    </ul>
                </div>
                <!-- SHOP LISTING-->
                <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <p class="text-sm text-muted mb-0">Showing
                                {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
                                results</p>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                                <li class="list-inline-item text-muted me-3">
                                    <a id="tow-block" class="reset-anchor p-0" href="javascript:void(0)">
                                        <i class="fas fa-th-large"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item text-muted me-3">
                                    <a id="three-block" class="reset-anchor p-0" href="javascript:void(0)">
                                        <i class="fas fa-th"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item w-75">
                                    {{-- create form with method get --}}
                                    <form action="{{ route('customer.products.sortBy', [$type, $slug]) }}">
                                        <select name="sortBy" onchange="this.form.submit()" class="selectpicker"
                                            data-customclass="form-control form-control-sm">
                                            <option value>Sort By </option>
                                            {{-- <a><option value="default">Default sorting </option> --}}
                                            <a>
                                                <option value="popularity">Popularity </option>
                                                <a>
                                                    <option value="low-high">Price: Low to High </option>
                                                    <a>
                                                        <option value="high-low">Price: High to Low </option>
                                        </select>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <x-store.view-products :products="$products" class="col-xl-4"></x-view-products>
                        {{-- <x-store.view-products :products="$featured_products" class="col-xl-3 col-lg-4 col-sm-6"></x-view-products> --}}
                        <!-- PAGINATION-->

                                    {{ $products->onEachSide(1)->appends(request()->input())->links() }}

                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        let maxQuantityMessage = "{{ __('This is the available quantity of the product.') }}";
        let success = "{{ __('Success') }}";
    </script>

    {{-- <script src="{{ asset('store/js/shopping.js') }}"></script> --}}
@endsection
