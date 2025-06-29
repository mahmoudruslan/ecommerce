<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Traits\HTMLTrait;
use Carbon\Carbon;
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
        ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $b = checkAbility('update-coupons', $permissions) ? $this->getEditLink("admin.coupons.edit", $row) : '';
                $b = $b.= checkAbility('show-coupons', $permissions) ? $this->getShowLink("admin.coupons.show", $row) : '';
                $b = $b .= checkAbility('delete-coupons', $permissions) ? $this->getDeleteLink("admin.coupons.destroy", $row) : '';
                return $b;
            })
            ->editColumn('start_date', function($row){
                return date('Y-m-d', strtotime($row->start_date));
            })
            ->editColumn('expire_date', function($row){
                return date('Y-m-d', strtotime($row->expire_date));
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d h:i', strtotime($row->created_at));
            })
            ->editColumn('status', function($row){
                return $row->status ? __('Active') : __('Inactive');
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
            Column::make('greater_than')->title(__('Greater than')),
            Column::make('status')->title(__('Status')),
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
