<?php

namespace App\DataTables;

use App\Models\UserAddress;
use App\Traits\Helper;
use App\Traits\HTMLTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserAddressDataTable extends DataTable
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
        $actions = $this->actionsAbility('user-addresses');
        return (new EloquentDataTable($query, $actions))
            ->addColumn('action', function($row) use($actions) {
                $id = encrypt($row->id);
                $b = $actions['update'] ? $this->getEditLink("admin.user-addresses.edit", $id) : '';
                $b = $b.= $actions['show'] ? $this->getShowLink("admin.user-addresses.show", $id) : '';
                $b = $b .= $actions['delete'] ? $this->getDeleteLink("admin.user-addresses.destroy", $id) : '';
                return $b;
            })
            ->editColumn('user_id', function($row){
                return $row->user->fullName;
            })
            ->editColumn('governorate_id', function($row){
                return $row->governorate['name_'. app()->getLocale()];
            })
            ->editColumn('city_id', function($row){
                return $row->city['name_'. app()->getLocale()];
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->rawColumns(['user_id', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserAddress $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserAddress $model): QueryBuilder
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
                    ->setTableId('useraddress-table')
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
            Column::make('user_id')->title(__('User')),
            Column::make('default_address')->title(__('Default address')),
            Column::make('address_title_en')->title(__('Address title in english')),
            Column::make('address_title_ar')->title(__('Address title in arabic')),
            Column::make('first_name')->title(__('First name')),
            Column::make('last_name')->title(__('Last name')),
            Column::make('email')->title(__('Email')),
            Column::make('mobile')->title(__('Mobile')),
            Column::make('address_ar')->title(__('Address in arabic')),
            Column::make('address_en')->title(__('Address in english')),
            Column::make('address2_ar')->title(__('Second address in arabic')),
            Column::make('address2_en')->title(__('Second address in english')),
            Column::make('governorate_id')->title(__('Governorate')),
            Column::make('city_id')->title(__('City')),
            Column::make('zip_code')->title(__('zip_code')),
            Column::make('po_box')->title(__('po_box')),
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
        return 'UserAddress_' . date('YmdHis');
    }
}
