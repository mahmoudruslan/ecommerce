<div class="modal fade" id="addToCart{{ $product->id }}" tabindex="-1" role="dialog">
    <div style="max-width: 400px;" class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0">
            <div class="modal-header p-0">
                <button class="btn-close p-4 top-0 end-0 z-index-20" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="cartForm{{$product->id}}" action="">
                <div class="modal-body text-start p-4">
                            <div class="align-items-stretch">
                                <h2 class="h4">{{ $product['name_' . $lang] }}</h2>
                                <p class="text-muted">{{ getCurrency() . number_format($product->price, 2) }}</p>

                                @if($product->has_variants)
                                    @php
                                        $variantPrimaryAttributeValues = $product->variants->pluck('primaryAttributeValue')->unique()->pluck('id')->toArray();
                                        $availableSecondaryAttributeValues = $product->variants->where('primaryAttributeValue.id', $variantPrimaryAttributeValues[0])->pluck('secondaryAttributeValue')->unique()->pluck('id')->toArray();
                                        $defaultSecondaryAttributeValueId = $product->variants->where('primaryAttributeValue.id', $variantPrimaryAttributeValues[0])->first()->secondaryAttributeValue->id;
                                        $defaultVariant = $product->variants->where('primaryAttributeValue.id', $variantPrimaryAttributeValues[0])->where('secondaryAttributeValue.id', $defaultSecondaryAttributeValueId)->first();
                                    @endphp
                                    <label class="form-label">{{ $product->variants->first()->primaryAttribute['name_' . app()->getLocale()] }}</label>:
                                    <span class="selected-value fw-bold" id="selected-primary-value"></span>
                                    <div class="row m-auto mb-2">
                                        @foreach ($product->variants->first()->primaryAttribute->values as $key => $value)
                                            <div class="col-2 p-1">
                                                <label for="value-{{$product->id}}-{{ $value->attribute_id }}-{{ $value->id}}"
                                                    class="{{ $value->id == $variantPrimaryAttributeValues[0] ? 'bg-primary' : '' }}
                                                    {{ !in_array($value->id, $variantPrimaryAttributeValues) ? 'disabled' : '' }}
                                                    w-100 primary-attribute rounded border p-1 text-center"
                                                    data-product="{{$product->id}}"
                                                    data-value="{{ $value->value_ar }}"
                                                    data-target="selected-primary-value">
                                                    <small>{{ $value->value_ar }}</small>
                                                </label>
                                                <input onclick="fetchSecondaryVariants('{{ route('customer.variants.attribute.values', [$product->id, $value->attribute_id, $value->id]) }}', {{ $product->id }}, {{ $value->id }})"
                                                    {{ !in_array($value->id, $variantPrimaryAttributeValues) ? 'disabled' : '' }}
                                                    {{ $value->id == $variantPrimaryAttributeValues[0] ? 'checked' : '' }}
                                                    style="display: none;"
                                                    type="radio"
                                                    name="primary_value_id"
                                                    id="value-{{ $product->id }}-{{$value->attribute_id}}-{{ $value->id}}"
                                                    value="{{ $value->id }}"
                                                    data-value="{{ $value->value_ar }}"
                                                    data-quantity="1">
                                            </div>
                                        @endforeach
                                    </div>
                                    <label class="form-label">{{ $product->variants->first()->secondaryAttribute['name_' . app()->getLocale()] }}</label>:
                                    <span class="selected-value fw-bold" id="selected-secondary-value"></span>
                                    <div class="row m-auto mb-2">
                                        <div class="row m-auto mb-2" id="secondary-values-{{$product->id}}">
                                            @foreach ($product->variants->first()->secondaryAttribute->values as $value)
                                                <div class="col-2 p-1">
                                                    <label for="value-{{$product->id}}-{{ $value->attribute_id }}-{{ $value->id}}"
                                                        class="w-100 secondary-attribute rounded border p-1 text-center secondary-value-label
                                                        {{ $value->id == $defaultSecondaryAttributeValueId ? 'bg-primary' : '' }}
                                                         {{ !in_array($value->id, $availableSecondaryAttributeValues) ? 'disabled' : '' }}"
                                                        data-product="{{$product->id}}"
                                                        data-value-id="{{ $value->id }}"
                                                        data-value="{{ $value->value_ar }}"
                                                        data-target="selected-secondary-value">
                                                        <small>{{ $value->value_ar }}</small>
                                                    </label>
                                                    <input
                                                        style="display: none"
                                                        type="radio"
                                                        {{ $value->id == $defaultSecondaryAttributeValueId ? 'checked' : '' }}
                                                        {{ !in_array($value->id, $availableSecondaryAttributeValues) ? 'disabled' : '' }}
                                                        name="secondary_value_id"
                                                        id="value-{{ $product->id }}-{{$value->attribute_id}}-{{ $value->id}}"
                                                        value="{{ $value->id }}"
                                                        data-value="{{ $value->value_ar }}"
                                                        data-quantity="1">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                                <div class="mb-4 g-3">
                                        <div class="col-sm-8 mb-4">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div
                                                        class="border d-flex align-items-center justify-content-between py-1 px-3 h-100">
                                                        <span
                                                            class="small text-gray mr-4 no-select">{{ __('Quantity') }}</span>
                                                        <div class="quantity">

                                                        <input type="hidden" id="product_id" value="{{ $product->id }}">
                                                            {{-- decreas --}}
                                                            <span class="dec-btn p-0"><i
                                                                    class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i></span>
                                                            <input id="quantity" name="quantity" value="1" style="background-color: #ffff" readonly type="text"
                                                                class="form-control border-0 shadow-0 p-0">
                                                            <input id="available_quantity_{{ $product->id }}" name="available_quantity" value="{{ $product->has_variants ? $defaultVariant->quantity : $product->quantity }}" min="1"
                                                                type="hidden">
                                                            {{-- increas --}}
                                                            <span class="inc-btn p-0"><i
                                                                    class="px-2 fas fa-caret-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a onclick="addToWishList({{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-wishlist')"
                                                        id="add-to-wishList-buttons"
                                                        class="add-wishlist-btn{{ $product->id }} btn btn-outline-dark border">
                                                        <i
                                                            class="{{ \Cart::session('wishList')->getContent()->pluck('id')->contains($product->id)? 'bold': '' }} far fa-heart heart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 m-auto">
                                            <a data-bs-dismiss="modal"
                                            aria-label="Close" class="btn btn-dark btn-sm w-100 mb-2" {{-- status = quantity status --}}
                                                onclick="addToCart( {{ $product->id }}, 'http\://{{ request()->httpHost() }}/add-to-cart')">
                                                {{ __('Add to cart') }}
                                            </a>
                                        </div>
                                    {{-- </form> --}}
                                    <div class="col-sm-12 m-auto">
                                        <a href="{{ route('customer.checkout') }}" class="w-100 btn btn-outline-dark">
                                            {{ __('Checkout') }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                </div>
            </form>
        </div>
    </div>
</div>
