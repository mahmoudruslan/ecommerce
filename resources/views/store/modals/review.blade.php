<div class="modal fade" id="productReview{{ $d_product->slug }}" tabindex="-1" role="dialog">


    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content overflow-hidden border-0">
            <div class="modal-header p-0">
                <button class="btn-close p-4 top-0 end-0 z-index-20 shadow-0" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="reviewForm" action="" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row align-items-stretch mb-5">
                        <div class="col-lg-12 text-center">
                            <h3>{{ __('How would you rate this item?') }}</h3>
                            <ul id="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <li class="list-inline-item">
                                        <label class="position-relative">
                                            <h1>
                                                <i data-value="{{ $i }}"
                                                    class="star far fa-star text-warning"></i>
                                            </h1>
                                            @if ($i == 1)
                                                <small class="max-content end-0 d-inline-block position-absolute">
                                                    {{ __('Dislike it') }}
                                                </small>
                                            @elseif($i == 5)
                                                <small class="max-content end-0 d-inline-block position-absolute">
                                                    {{ __('Love it') }}
                                                </small>
                                            @endif
                                        </label>

                                    </li>
                                @endfor
                                <input type="hidden" id="rating-value" name="rating" value="0">
                            </ul>
                            <small class="error text-danger" id="rating_error"></small>
                        </div>
                    </div>
                    <div class="row gy-2">
                        <div class="col-lg-4">
                            <input type="text" name="first_name" class="form-control form-control-lg" placeholder="{{__('First name')}}">
                            <small class="error text-danger" id="first_name_error"></small>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" name="last_name" class="form-control form-control-lg" placeholder="{{__('Last name')}}">
                            <small class="error text-danger" id="last_name_error"></small>
                        </div>
                        <div class="col-lg-4">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="{{__('Email')}}">
                            <small class="error text-danger" id="email_error"></small>
                        </div>
                        <div class="col-lg-12">
                            <textarea  name="body" class="form-control form-control-lg" placeholder="{{__('Last name')}}"></textarea>
                            <small class="error text-danger" id="body_error"></small>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <span onclick="sendReview('{{$d_product->slug}}' , 'http\://{{ request()->httpHost() }}/product-review')" class="w-100 btn btn-outline-dark">{{__('Send')}}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
