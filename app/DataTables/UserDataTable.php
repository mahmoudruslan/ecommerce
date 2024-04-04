<?php

namespace App\DataTables;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;

class UserDataTable extends DataTable
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
        $actions = $this->actionsAbility('users');
        return (new EloquentDataTable($query, $actions))
            ->addColumn('action', function($row) use($actions) {
                $id = encrypt($row->id);
                $b = $actions['update'] ? $this->getEditLink("admin.users.edit", $row->slug, $id) : '';
                $b = $b.= $actions['show'] ? $this->getShowLink("admin.users.show", $row->slug, $id) : '';
                $b = $b .= $actions['delete'] ? $this->getDeleteLink("admin.users.destroy", $id) : '';
                return $b;
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('image', function($row){
                return $row->image ? '<img style="height: auto;width: 100%" src="'. asset('storage/'.$row->image) .'" alt="category photo">' : __('Image Not Found');
            })
            ->rawColumns(['status', 'action', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
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
                    ->setTableId('user-table')
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
            Column::make('first_name')->title(__('First Name')),
            Column::make('last_name')->title(__('Last Name')),
            Column::make('username')->title(__('Username')),
            Column::make('email')->title(__('Email')),
            Column::make('status')->title(__('Status')),
            Column::make('mobile')->title(__('Mobile')),
            Column::make('image')->title(__('Image')),
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
        return 'User_' . date('YmdHis');
    }

}
