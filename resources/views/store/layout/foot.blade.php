      <!-- JavaScript files-->
      <script src="{{ asset('store/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('store/vendor/glightbox/js/glightbox.min.js') }}"></script>
      <script src="{{ asset('store/vendor/nouislider/nouislider.min.js') }}"></script>
      <script src="{{ asset('store/vendor/swiper/swiper-bundle.min.js') }}"></script>
      <script src="{{ asset('store/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
      <script src="{{ asset('store/js/front.js') }}"></script>
      <script src="{{ asset('store/js/alert.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      @livewireScripts

      {{-- alert icons --}}
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


      @include('sweetalert::alert')


      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      </div>
      <script>
          let currency = "{{ getCurrency() }}";
          let maxQuantityMessage = "{{ __('This is the available quantity of the product.') }}";
          let success = "{{ __('Success') }}";
          let warning = "{{ __('Warning') }}";
          let noProducts = "{{ __('No products available in your cart.') }}";
          let noWishlistProducts = "{{ __('No products available in your wishlist.') }}";
          let requiredMessage = "{{ __('validation.required') }}";
          let emailMessage = "{{ __('validation.email') }}";
          let size = "{{ __('Size') }}";
      </script>
      @yield('js')
      <script src="{{ asset('store/js/helper.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/index.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/cart.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/wishlist.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/coupon.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/checkout.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/profile.js') }}" type="text/javascript"></script>
      <script src="{{ asset('store/js/variants.js')}}"></script>
      </body>

      </html>
