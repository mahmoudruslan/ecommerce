<div wire:ignore class="modal fade" id="productView{{$product->slug}}" tabindex="-1" role="dialog" aria-hidden="true">
        
    @php
        $lang = app()->getLocale();
    @endphp
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content overflow-hidden border-0">
            <div class="modal-body p-0">
                {{-- @if($showModal == true) --}}
                <div class="row align-items-stretch">
                    <div class="col-lg-6">
                        <div class="p-4 my-md-4">
                            <ul class="list-inline mb-2">
                                @for ($i = 0; $i < 5; $i++)
                                    
                                <li class="list-inline-item m-0"><i class="{{round($product->reviews_avg_rating) > $i ? 'fas' : 'far'}} fa-star small text-warning"></i>
                                @endfor
                                </li>
                            </ul>
                            <h2 class="h4">{{ $product['name_' . $lang] }}</h2>
                            <p class="text-muted">LE. {{ $product->price }}</p>
                            <p class="text-sm mb-4">{{ $product['description_' . $lang] }}</p>
                            <div class="row align-items-stretch mb-4 gx-0">
                                <div class="col-sm-5"><a
                                        class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0"
                                        wire:click="addToCart({{$product->id}})">{{ __('Add to cart') }}</a></div>
                                <div class="col-sm-7">
                                    <div class="border d-flex align-items-center justify-content-between py-1 px-3">
                                        <span
                                            class="small text-uppercase text-gray mr-4 no-select">{{ __('Quantity') }}</span>
                                        <div class="quantity">
                                            <button wire:click="decreaseQuantity()" class="p-0"><i class="fas fa-caret-left"></i></button>
                                            <input style="background-color: #ffff" readonly type="text" wire:model="quantity"  class="form-control border-0 shadow-0 p-0">
                                            <button wire:click="increaseQuantity('{{$product->quantity}}')" class="p-0"><i class="fas fa-caret-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div><a class="btn btn-link text-dark text-decoration-none p-0" wire:click="addToWishList({{$product->id}})"><i
                                    class="far fa-heart me-2"></i>{{__('Add to wish list')}}</a>
                        </div>
                    </div>
                    <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="col-lg-6 p-lg-0">
                        @foreach ($product->media as $media)
                            @if ($loop->first)
                                <a class="glightbox product-view d-block h-100 bg-cover bg-center"
                                    style="background: url({{ asset('storage/' . $media->file_name) }})"
                                    href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}"
                                    data-glightbox="Red digital smartwatch">
                                </a>
                            @else
                                <a class="glightbox d-none" href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}"
                                    data-glightbox="Red digital smartwatch">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>