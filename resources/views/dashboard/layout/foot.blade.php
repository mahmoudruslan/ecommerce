    <!-- Bootstrap core JavaScript-->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script src="{{asset('dashboard/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('dashboard/js/sb-admin-2.min.js')}}"></script>
    <!-- custom js code-->
    <script src="{{asset('dashboard/js/custom.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('dashboard/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('dashboard/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('dashboard/js/demo/chart-pie-demo.js')}}"></script>
   <!--  data table -->
   <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js" > </script>
   <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap4.min.js" ></script>
@stack('script')
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
