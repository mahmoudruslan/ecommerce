<?php

namespace App\DataTables;

use App\Models\Category;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;
use Illuminate\Support\Facades\App;

class CategoryDataTable extends DataTable
{
    use HTMLTrait, Helper;


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $actions = $this->actionsAbility('categories');
        return (new EloquentDataTable($query, $actions))
            ->addColumn('action', function($row) use ($actions) {
                $id = encrypt($row->id);

                $b = $actions['update'] ? $this->getEditLink("admin.categories.edit", $id) : '';
                $b = $b .= $actions['show'] ? $this->getShowLink("admin.categories.show", $id) : '';
                $b = $b .= $actions['delete'] ? $this->getDeleteLink("admin.categories.destroy", $id) : '';
                return $b;
            })
            ->addColumn('product_count', function($row){
                return $row->products_count;
            })
            ->addColumn('parent', function($row){
                return $row->parent['name_' . App::currentLocale()] ?? '<span style="cursor: auto" class="btn btn-success">'. __('Parent') .'</span>';
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->editColumn('image', function($row){
                return $row->image ? '<img style="height: auto;width: 100%" src="'. asset('storage/'.$row->image) .'" alt="category photo">' : __('Image Not Found');
            })
            ->rawColumns(['status', 'action', 'parent_id', 'created_at', 'image', 'parent']);
    }


    public function query(Category $model): QueryBuilder
    {
        return $model->withCount('products')->with('parent')->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
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
            Column::make('id'),
            Column::make('name_ar')->title(__('Name In Arabic')),
            Column::make('name_en')->title(__('Name In English')),
            Column::make('status')->title(__('Status')),
            // Column::make('parent_id')->title(__('Parent')),
            Column::make('image')->title(__('Image')),
            Column::make('created_at')->title(__('Created At')),
            Column::make('product_count')->title(__('Product Count')),
            Column::make('parent')->title(__('Parent Category')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
