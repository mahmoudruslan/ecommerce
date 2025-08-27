    <!-- Bootstrap core JavaScript-->
    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script src="{{asset('dashboard/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('dashboard/js/sb-admin-2.min.js')}}"></script>
    <!-- custom js code-->
    <script src="{{asset('dashboard/js/custom.js')}}"></script>
    <script src="{{asset('dashboard/js/variants.js')}}"></script>




    {{-- bootstrap file input package => show and delete image selected--}}
    <script src="{{asset('dashboard/vendor/bootstrap-file-input/themes/fa4/theme.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/bootstrap-file-input/js/plugins/piexif.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/bootstrap-file-input/js/plugins/sortable.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/bootstrap-file-input/js/fileinput.min.js')}}"></script>
    {{-- <script src="{{asset('dashboard/vendor/bootstrap-file-input/js/locales/ar.js')}}"></script> --}}



   <!--  data table -->
   <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js" > </script>
   <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap4.min.js" ></script>
@stack('script')
@include('sweetalert::alert')

<script>
    //hide alert after 2 second
    window.onload = function flashAlert() {
        setInterval(function () {
            let alert = document.getElementById("alert");
            if (alert) {
            alert.classList.add('hidden');
            }
        }, 2000);
};
</script>
</body>
</html>
