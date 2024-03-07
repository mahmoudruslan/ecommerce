<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;

class ProductDataTable extends DataTable
{
    use HTMLTrait;
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('action', function($row){
                $id = encrypt($row->id);
                $b =  $this->getEditLink("admin.products.edit", $row->slug, $id);
                $b = $b. $this->getShowLink("admin.products.show", $row->slug, $id);
                $b = $b .= $this->getDeleteLink($row->slug, $id);
                return $b;
            })
            ->addColumn('parent_category', function($row){
                return $row->category->parent->name_ar;
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('featured', function($row){
                return $this->getStatusIcon($row->featured);
            })
            ->editColumn('category_id', function($row){
                if ($row->category_id != null) {
                    return $row->category->name_ar;
                }
            })
            // ->editColumn('image', function($row){

            //         return '<img src="'. asset('dashboard/img/'. $row->image) .'" alt="category photo">';

            // })
            ->rawColumns(['status', 'action', 'featured', 'category_id', 'parent_category', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->orderBy('id', 'desc')->newQuery();
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
                    // ->orderBy(0, 'desk')
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
            Column::make('row_number')
            ->title('#')
            ->render('meta.row + meta.settings._iDisplayStart + 1;')
            ->width(50)
            ->orderable(false),
            Column::make('name_ar')->title(__('Name In Arabic')),
            Column::make('name_en')->title(__('Name In English')),
            Column::make('slug')->title(__('Slug')),
            Column::make('price')->title(__('Price')),
            Column::make('description_ar')->title(__('Description In Arabic')),
            Column::make('description_en')->title(__('Description In English')),
            Column::make('quantity')->title(__('Quantity')),
            Column::make('parent_category')->title(__('Parent Category')),
            Column::make('category_id')->title(__('Category')),
            Column::make('featured')->title(__('Featured')),
            Column::make('status')->title(__('Status')),
            // Column::make('image')->title(__('Image')),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
            // Column::make('actions'),
            // Column::make('link')

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
