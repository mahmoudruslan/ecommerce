<?php

namespace App\DataTables;

use App\Models\PaymentMethod;
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

class PaymentMethodDataTable extends DataTable
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
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $b = checkAbility('update-payment-methods', $permissions) ? $this->getEditLink("admin.payment-methods.edit", $row) : '';
                $b = $b .= checkAbility('delete-payment-methods', $permissions) ? $this->getDeleteLink("admin.payment-methods.destroy", $row) : '';
                return $b;
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PaymentMethod $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PaymentMethod $model): QueryBuilder
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
                    ->setTableId('paymentmethod-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
            Column::make('name')->title(__('Name')),
            Column::make('code')->title(__('Code')),
            Column::make('driver_name')->title(__('driver_name')),
            Column::make('merchant_email')->title(__('merchant_email')),
            Column::make('username')->title(__('Username')),
            Column::make('password')->title(__('Password')),
            Column::make('secret')->title(__('Secret')),
            Column::make('sandbox_username')->title(__('sandbox_username')),
            Column::make('sandbox_password')->title(__('sandbox_password')),
            Column::make('sandbox_secret')->title(__('sandbox_secret')),
            Column::make('sandbox')->title(__('sandbox')),
            Column::make('status')->title(__('Status')),
            Column::computed('action')->title(__('Action'))

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
        return 'Product_' . date('YmdHis');
    }
}
