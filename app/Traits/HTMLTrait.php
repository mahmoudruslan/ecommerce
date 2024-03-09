<?php

namespace App\Traits;
use Illuminate\Http\Request;


trait HTMLTrait {
    public function getModal($route, $id)
        {
            return '<div class="modal fade" id="DeleteModal'. $id .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        public function getStatusIcon($status){
        if ($status == '1') {
            return '<div class="btn-circle btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></div>';
        }else{
            return '<div class="btn-circle btn-sm btn-success"><i class="fa fa-times text-danger" aria-hidden="true"></i></div>';
        }
    }

    public function getEditLink($route, $slug, $id)
    {
        return '<div role="group" aria-label="Basic example" class="btn-group" style="width: 150px"> <a href=" ' . route($route, [$slug, $id]) . '" class=" btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>';
    }
    public function getShowLink($route, $slug, $id)
    {
        return '<a href=" ' . route($route, [$slug, $id]) . '" class=" btn btn-warning btn-sm"><i class="fas fa-fw fa-eye"></i></a>';
    }
    public function getDeleteLink($route, $id)
    {
        $btn = ' <a href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModal'. $id.'" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i></a></div>';
        $btn = $btn. $this->getModal($route, $id);
        return $btn;
    }
}
