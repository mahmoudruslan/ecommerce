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
                // dd($row->id);
                $btn = '<div style="width: 150px"> <a href=" ' . route("admin.products.edit", [$row->slug, $id]) . '" class=" btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>';
                $btn = $btn. '<div style="width: 150px"> <a href=" ' . route("admin.products.show", [$row->slug, $id]) . '" class=" btn btn-warning btn-sm"><i class="fas fa-fw fa-eye"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModal'. $id.'" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i></a></div>';
                $btn = $btn. $this->getModal('admin.products.destroy', $id);

            return $btn;
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
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
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('name_ar'),
            Column::make('name_en'),
            Column::make('slug'),
            Column::make('price'),
            Column::make('description_ar'),
            Column::make('description_en'),
            Column::make('quantity'),
            Column::make('category_id'),
            Column::make('featured'),
            Column::make('status'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
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
