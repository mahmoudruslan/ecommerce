<?php

namespace App\DataTables;

use App\Models\Review;
use App\Traits\Helper;
use App\Traits\HTMLTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewDataTable extends DataTable
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
        $actions = $this->actionsAbility('reviews');
        return (new EloquentDataTable($query, $actions))
            ->addColumn('action', function($row) use ($actions) {
                $id = encrypt($row->id);
                $b = $actions['show'] ? $this->getShowLink("admin.reviews.show", $id) : '';
                $b = $b .= $actions['delete'] ? $this->getDeleteLink("admin.reviews.destroy", $id) : '';
                return $b;
            })
            ->editColumn('user_id', function($row){
                return $row->user_id ? $row->user->fullName : __('Guest');
            })
            ->editColumn('product_id', function($row){
                return $row->product['name_' . app()-> getLocale()];
            })
            ->editColumn('status', function($row){
                return $this->getStatusIcon($row->status);
            })
            ->editColumn('body', function($row){
                return substr($row->body, 0, 20) . '...';
            })
            ->editColumn('title', function($row){
                return substr($row->title, 0, 20) . '...';
            })
            ->editColumn('created_at', function($row){
                return date('Y-m-d', strtotime($row->created_at));
            })
            ->rawColumns(['status', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Review $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Review $model): QueryBuilder
    {
        return $model->with(['user:id,first_name,last_name','product:id,name_ar,name_en'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('review-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    // ->orderBy(0)
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
            Column::make('product_id')->title(__('Product')),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('title')->title(__('Title')),
            Column::make('body')->title(__('Review text')),
            Column::make('status')->title(__('Status')),
            Column::make('rating')->title(__('Rating')),
            Column::make('created_at')->title(__('Created At')),
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
        return 'Review_' . date('YmdHis');
    }
}
