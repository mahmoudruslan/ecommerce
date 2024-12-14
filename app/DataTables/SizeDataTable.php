<?php

namespace App\DataTables;

use App\Models\Size;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;

class SizeDataTable extends DataTable
{
    use HTMLTrait;
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $b = checkAbility('update-sizes', $permissions) ? $this->getEditLink("admin.sizes.edit", $row->id) : '';
                $b = $b .= checkAbility('delete-sizes', $permissions) ? $this->getDeleteLink("admin.sizes.destroy", $row->id) : '';
                return $b;
            })
            ->editColumn('created_at', function ($row) {
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->rawColumns(['action', 'created_at']);
    }


    public function query(Size $model): QueryBuilder
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
            ->setTableId('size-table')
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
            Column::make('id'),
            Column::make('name')->title(__('Name')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
    protected function filename(): string
    {
        return 'Size_' . date('YmdHis');
    }
}
