<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\User;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;
use Illuminate\Support\Facades\App;

class VariantDataTable extends DataTable
{
    use HTMLTrait;
    // protected $actions=[];
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $b = checkAbility('update-variants', $permissions) ? $this->vgetEditLink("admin.products.variants.edit", $row) : '';
                $b = $b.= checkAbility('show-variants', $permissions) ? $this->vgetShowLink("admin.products.variants.show", $row) : '';
                $b = $b.= checkAbility('delete-variants', $permissions) ? $this->vgetDeleteLink("admin.products.variants.destroy", $row) : '';
                return $b;
            })

            ->addColumn('product_id', function($row){
                return $row->product['name_' . App::currentLocale()];
            })
            ->addColumn('primary_attribute_value_id', function($row){
                return $row->primaryAttributeValue['value_' . App::currentLocale()];
            })
            ->addColumn('secondary_attribute_value_id', function($row){
                return $row->secondaryAttributeValue['value_' . App::currentLocale()];
            })
            ->rawColumns(['image', 'product_id', 'action']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->product->variants();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('variant-table')
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
            Column::make('product_id')->title(__('Product name')),
            Column::make('price')->title(__('Price')),
            Column::make('sku')->title(__('Sku'))->addClass('text-center'),
            Column::make('quantity')->title(__('Quantity')),
            Column::make('primary_attribute_value_id')->title(__('Primary Attribute')),
            Column::make('secondary_attribute_value_id')->title(__('Secondary Attribute')),
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
        return 'Variant_' . date('YmdHis');
    }
}
