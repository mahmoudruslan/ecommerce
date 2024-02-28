<?php

namespace App\Traits;
use Illuminate\Http\Request;


trait HTMLTrait {
    public function getModal($route, $id)
        {
            return '<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">'.__("Warning").'</h5>
                        <button class="close close-l" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">'.__("Are you sure you want to delete the item?").'</div>
                    <form action="'. route($route, $id).'" method="post">
                    '.method_field("DELETE").'
                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">' .__("Cancel").'</button>
                        <button class="btn btn-danger" type="submit">'.__("Delete").'</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>';
        }
}
