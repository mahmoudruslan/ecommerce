<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;
use Illuminate\Support\Facades\App;

class ProductDataTable extends DataTable
{
    use HTMLTrait;
    // protected $actions=[];
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $lang = app()->getLocale();
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $b = checkAbility('update-products', $permissions) ? $this->getEditLink("admin.products.edit", $row) : '';
                $b = $b.= checkAbility('show-products', $permissions) ? $this->getShowLink("admin.products.show", $row) : '';
                $b = $b.= checkAbility('delete-products', $permissions) ? $this->getDeleteLink("admin.products.destroy", $row) : '';
                return $b;
            })
            ->addColumn('parent_category', function($row){
                return $row->category->parent['name_' . App::currentLocale()];
            })
            ->addColumn('image', function($row){
                return $row->firstMedia ? '<img style="height: auto;width: 100%" src="'. asset('storage/' . $row->firstMedia->file_name) .'" alt="category photo">' : __('Image Not Found');
            })
            ->addColumn('has_variants', function($row){
                return $this->getStatusIcon($row->has_variants);
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('name', function($row) use ($lang){
                return $row['name_' . $lang];
            })
            ->editColumn('category_id', function($row){
                    return $row->category['name_' . App::currentLocale()];
            })
            ->rawColumns(['name_ar', 'status', 'has_variants', 'action', 'featured', 'category_id', 'parent_category', 'image']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->with([
            'category:id,name_ar,name_en,parent_id' =>
                ['parent:id,name_ar,name_en'],
            'tags',
            'firstMedia:mediable_id,file_name',
            ])->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
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

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name_ar')->title(__('Name')),
            Column::make('has_variants')->title(__('Variants')),
            Column::make('price')->title(__('Price')),
            Column::make('parent_category')->title(__('Parent Category')),
            Column::make('category_id')->title(__('Category')),
            Column::make('status')->title(__('Status')),
            Column::make('image')->title(__('Image')),
            Column::computed('action')->title(__('Action'))
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
