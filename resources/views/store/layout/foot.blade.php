      <!-- JavaScript files-->
      <script src="{{asset('store/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('store/vendor/glightbox/js/glightbox.min.js')}}"></script>
      <script src="{{asset('store/vendor/nouislider/nouislider.min.js')}}"></script>
      <script src="{{asset('store/vendor/swiper/swiper-bundle.min.js')}}"></script>
      <script src="{{asset('store/vendor/choices.js/public/assets/scripts/choices.min.js')}}"></script>
      <script src="{{asset('store/js/front.js')}}"></script>
      <script src="{{asset('store/js/custom.js')}}"></script>
      {{-- livewire scripts | alert --}}
      @livewireScripts
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
      <x-livewire-alert::scripts />
      <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite -
        //   see more here
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {

            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

      </script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </div>
  </body>
</html>
