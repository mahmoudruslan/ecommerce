<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;

class RoleDataTable extends DataTable
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
            $b = '<div style="width: 150px"> <a href=" ' . route("admin.permission-role.edit", $id) . '" class=" btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>';
            // $b = $b. $this->getShowLink("admin.permissions-role.show", $row->slug, $id);
            $b = $b . $this->getDeleteLink("admin.permission-role.destroy", $id);
            return $b;
        })
            // ->addColumn('action', function($row){
            //     $id = encrypt($row->id);
            //     $btn = '<div style="width: 150px"> <a href=" ' . route("admin.permission-role.edit", $id) . '" class=" btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>';
            //     $btn = $btn.' <a href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModal'. $id.'" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i></a></div>';
            //     $btn = $btn. $this->getModal('admin.permission-role.destroy', $id);

            // return $btn;
            // })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model): QueryBuilder
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
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
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
            Column::make('name')->title(__('Role Name')),
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
        return 'Role_' . date('YmdHis');
    }
}
