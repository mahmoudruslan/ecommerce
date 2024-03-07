<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Traits\HTMLTrait;


class CategoryDataTable extends DataTable
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
                $b =  $this->getEditLink("admin.categories.edit", $row->slug, $id);
                $b = $b. $this->getShowLink("admin.categories.show", $row->slug, $id);
                $b = $b .= $this->getDeleteLink($row->slug, $id);
                return $b;
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('parent_id', function($row){
                if ($row->parent_id != null) {
                    return $row->parent->name_ar;
                }
                return '<span class="text-info">Parent</span>';
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->editColumn('image', function($row){
                return '<img src="'. asset('dashboard/img/'. $row->image) .'" alt="category photo">';
            })
            ->rawColumns(['status', 'action', 'parent_id', 'created_at', 'image']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model): QueryBuilder
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
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->parameters([

                        'language' => asset('dashboard/js/arabic.js')
                    ])
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

            Column::make('row_number')
            ->title('#')
            ->render('meta.row + meta.settings._iDisplayStart + 1;')
            ->width(50)
            ->orderable(false),
            Column::make('name_ar')->title(__('Name In Arabic')),
            Column::make('name_en')->title(__('Name In English')),
            Column::make('status')->title(__('Status')),
            Column::make('parent_id')->title(__('Parent')),
            Column::make('image')->title(__('Image')),
            Column::make('created_at')->title(__('Created At')),
            // Column::make('updated_at'),
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
        return 'Category_' . date('YmdHis');
    }
}
