<div class="modal fade" id="productView{{$product->slug}}" tabindex="-1" role="dialog" aria-hidden="true">

    @php
        $lang = app()->getLocale();
    @endphp
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content overflow-hidden border-0">
            <div class="modal-body p-0">
                <div class="row align-items-stretch">
                    <div class="col-lg-6">
                        <div class="p-4 my-md-4">
                            <ul class="list-inline mb-2">
                                @for ($i = 0; $i < 5; $i++)
                                    <li class="list-inline-item m-0"><i
                                            class="{{ round($product->reviews_avg_rating) > $i ? 'fas' : 'far' }} fa-star small text-warning"></i>
                                @endfor
                                </li>
                            </ul>
                            <h2 class="h4">{{ $product['name_' . $lang] }}</h2>
                            <p class="text-muted">{{ getCurrency() . number_format($product->price, 2) }}</p>
                            <p class="text-sm mb-4">{{ $product['description_' . $lang] }}</p>
                        </div>
                    </div>
                    <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="col-lg-6 p-lg-0">
                        @foreach ($product->images as $media)
                            @if ($loop->first)
                                <a class="glightbox product-view d-block h-100 bg-cover bg-center"
                                    style="background: url({{ asset('storage/' . $media->file_name) }})"
                                    href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}" data-glightbox="Red digital smartwatch">
                                </a>
                            @else
                                <a class="glightbox d-none" href="{{ asset('storage/' . $media->file_name) }}"
                                    data-gallery="gallery{{ $product->id }}" data-glightbox="Red digital smartwatch">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

