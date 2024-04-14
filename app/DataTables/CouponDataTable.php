<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Traits\Helper;
use App\Traits\HTMLTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
{
    use HTMLTrait, Helper;
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $actions = $this->actionsAbility('coupons');
        return (new EloquentDataTable($query, $actions))
            ->addColumn('action', function($row) use  ($actions){
                $b = $actions['update'] ? $this->getEditLink("admin.products.edit", '', $row->id) : '';
                $b = $b.= $actions['show'] ? $this->getShowLink("admin.products.show", '', $row->id) : '';
                $b = $b .= $actions['delete'] ? $this->getDeleteLink("admin.products.destroy", $row->id) : '';
                return $b;   
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Coupon $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Coupon $model): QueryBuilder
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
                    ->setTableId('coupon-table')
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
            Column::make('code')->title(__('Code')),
            Column::make('type')->title(__('Type')),
            Column::make('value')->title(__('Value')),
            Column::make('description_en')->title(__('Description')),
            Column::make('use_times')->title(__('Use times')),
            Column::make('used_times')->title(__('Used times')),
            Column::make('start_date')->title(__('Start date')),
            Column::make('expire_date')->title(__('Expire date')),
            Column::make('generate_than')->title(__('Greater than')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')
            ->title( __('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Coupon_' . date('YmdHis');
    }
}
