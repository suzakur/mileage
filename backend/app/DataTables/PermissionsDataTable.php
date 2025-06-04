<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;

class PermissionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['actions', 'assigned_to'])
            ->editColumn('name', function (Permission $permission) {
                return ucwords($permission->name);
            })
            ->addColumn('assigned_to', function (Permission $permission) {
                $html = '';
                foreach($permission->roles as $role) {
                    $html .= '<a href="#" class="badge fs-7 m-1 badge-light-primary '.$role->name.'">'. $role->name.'</a>';
                }
                return $html;
            })
            ->editColumn('group_name', function (Permission $permission) {
                return ucwords($permission->group_name);
            })
            ->editColumn('updated_at', function (Permission $permission) {
                return $permission->updated_at->format('d M Y, h:i a');
            })
            ->addColumn('actions', function (Permission $permission) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$permission->id.'" data-name="'.$permission->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$permission->id.'" data-name="'.$permission->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model): QueryBuilder
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
            ->setTableId('permissions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('assigned_to'),
            Column::make('group_name'),
            Column::make('created_at')->addClass('text-nowrap'),
            Column::computed('actions')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Permissions_' . date('YmdHis');
    }
}
