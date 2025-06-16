<?php

namespace App\DataTables;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;
use Illuminate\Support\Facades\App;

class AttributeDataTable extends DataTable
{
    use HTMLTrait;


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                Log::debug('permissions', $permissions);

                $button = checkAbility('update-attributes', $permissions) ? $this->getEditLink("admin.attributes.edit", $row->id) : '';
                $button = $button .= checkAbility('show-attributes', $permissions) ? $this->getShowLink("admin.attributes.show", $row->id) : '';
                $button = $button .= checkAbility('delete-attributes', $permissions) ? $this->getDeleteLink("admin.attributes.destroy", $row->id) : '';
                return $button;
            })
//            ->addColumn('product_count', function($row){
//                return $row->products_count;
//            })
//            ->addColumn('parent', function($row){
//                return $row->parent['name_' . App::currentLocale()] ?? '<span style="cursor: auto" class="btn btn-success">'. __('Parent') .'</span>';
//            })
//            ->editColumn('status', function($row){
//                return $this->getStatusIcon($row->status);
//            })
//            ->editColumn('created_at', function($row){
//                return date('Y-m-d', strtotime($row->created_at));
//            })
//            ->editColumn('image', function($row){
//                return $row->image ? '<img style="height: auto;width: 100%" src="'. asset('storage/'.$row->image) .'" alt="category photo">' : __('Image Not Found');
//            })
            ->rawColumns(['action'])
            ;
    }


    public function query(Attribute $model): QueryBuilder
    {
        return $model->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attribute-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }


    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->addClass('text-center'),
            Column::make('name_'. app()->getLocale())->title(__('Name'))
                ->addClass('text-center'),
            Column::make('type')->title(__('Type'))
                ->addClass('text-center'),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    protected function filename(): string
    {
        return 'Attribute_' . date('YmdHis');
    }
}
