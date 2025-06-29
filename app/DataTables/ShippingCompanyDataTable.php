<?php

namespace App\DataTables;

use App\Models\ShippingCompany;
use App\Traits\HTMLTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShippingCompanyDataTable extends DataTable
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
                $b = checkAbility('update-shipping-companies', $permissions) ? $this->getEditLink("admin.shipping-companies.edit", $row) : '';
                $b = $b.= checkAbility('show-shipping-companies', $permissions) ? $this->getShowLink("admin.shipping-companies.show", $row) : '';
                $b = $b .= checkAbility('delete-shipping-companies', $permissions) ? $this->getDeleteLink("admin.shipping-companies.destroy", $row) : '';
                return $b;
            })
            ->editColumn('status', function($row){
                return $row->status();
            })
            ->editColumn('fast', function($row){
                return $row->fast();
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->rawColumns(['status', 'action', 'fast']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShippingCompany $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShippingCompany $model): QueryBuilder
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
                    ->setTableId('shippingcompany-table')
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

            Column::make('name_ar')->title(__('Name in arabic')),
            Column::make('name_en')->title(__('Name in english')),
            Column::make('code')->title(__('Code')),
            Column::make('description_ar')->title(__('Description in arabic')),
            Column::make('description_en')->title(__('Description in english')),
            Column::make('fast')->title(__('Fast')),
            Column::make('coast')->title(__('Coast')),
            Column::make('status')->title(__('Status')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')
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
        return 'ShippingCompany_' . date('YmdHis');
    }
}
