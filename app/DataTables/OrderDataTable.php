<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;
use Illuminate\Support\Facades\App;

class OrderDataTable extends DataTable
{
    use HTMLTrait;


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $id = encrypt($row->id);
                // $b = checkAbility('update-categories', $permissions) ? $this->getEditLink("admin.categories.edit", $id) : '';
                $b = checkAbility('show-orders', $permissions) ? '<div role="group" aria-label="Basic example" class="btn-group" style="width: 150px">'.$this->getShowLink("admin.orders.show", $id) : '';
                $b = $b .= checkAbility('delete-orders', $permissions) ? $this->getDeleteLink("admin.orders.destroy", $id) : '';
                return $b;
            })
            ->editColumn('status', function($row){
                return $row->statusWithHtml();
            })
            ->editColumn('user_id', function($row){
                return $row->user_id != null ? $row->customer->fullName : $row->orderAddress->fullName;
            })
            ->addColumn('customer_type', function($row){
                return $row->user_id != null ? __('Authenticated') : __('Guest');
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->rawColumns(['status', 'action', 'created_at', 'customer_type']);
    }

    public function query(Order $model): QueryBuilder
    {
        // return $model->withCount('products')->with('parent')->newQuery();
        return $model->with(['customer'])->newQuery();
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
            Column::make('ref_id')->title(__('Reference ID')),
            Column::make('user_id')->title(__('Customer')),
            Column::make('customer_type')->title(__('Customer type')),
            Column::make('status')->title(__('Status')),
            Column::make('payment_method')->title(__('Payment method')),
            Column::make('total')->title(__('Total')),
            Column::make('created_at')->title(__('Created at:')),
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
