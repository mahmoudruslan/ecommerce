<?php

namespace App\DataTables;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;

class AttributeValueDataTable extends DataTable
{
    use HTMLTrait;
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $permissions = $this->permissions; // receiving permissions variable from controller
                $button = checkAbility('update-attribute-values', $permissions) ? $this->getEditLink("admin.attribute-values.edit", $row) : '';
                $button = $button .= checkAbility('show-attribute-values', $permissions) ? $this->getShowLink("admin.attribute-values.show", $row) : '';
                $button = $button .= checkAbility('delete-attribute-values', $permissions) ? $this->getDeleteLink("admin.attribute-values.destroy", $row) : '';
                return $button;
            })
            ->editColumn('attribute_id', function($row) {
                return $row->attribute['name_' . app()->getLocale()];
            })
            ->rawColumns(['action']);
    }


    public function query(AttributeValue $model): QueryBuilder
    {
        return $model->with('attribute')->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attribute-value-table')
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
            Column::make('id')
                ->addClass('text-center'),
            Column::make('value_'. app()->getLocale())->title(__('Value'))
                ->addClass('text-center'),
            Column::make('attribute_id')->title(__('Attribute'))
                ->addClass('text-center'),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    protected function filename(): string
    {
        return 'AttributeValue_' . date('YmdHis');
    }
}
