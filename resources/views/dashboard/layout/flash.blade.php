@if (Session::has('message'))
    <div id="alert" style="width: 100%;">
        <div style="width: 95%;margin:auto;text-align: center" class="alert alert-{{ Session::get('alert-type') }} alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
        </div>
    </div>
@endif
