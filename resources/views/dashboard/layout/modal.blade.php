
        <!-- Logout Modal-->

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __("Warning") }}</h5>
                    <button class="close close-l" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{ __("Are you sure you want to logput?") }}</div>
                <form action="{{ route('logout') }}" method="post">
                {{-- @method('DELETE') --}}
                @csrf
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __("Cancel") }}</button>
                    <button class="btn btn-danger" type="submit">{{ __("Logout") }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
