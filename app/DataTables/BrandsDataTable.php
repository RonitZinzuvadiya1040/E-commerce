<?php

namespace App\DataTables;

use App\Models\Brand;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;

class BrandsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($brand) {
                $editRoute = route('admin.brand.edit', $brand->id);
                $deleteRoute = route('admin.brand.destroy', $brand->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return <<<HTML
                <a href="{$editRoute}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{$deleteRoute}" method="POST" style="display:inline;">
                    {$csrf}
                    {$method}
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete {$brand->name} brand?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
HTML;
            });
    }

    public function query(Brand $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('brands-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('image'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    // protected function filename()
    // {
    //     return 'Brands_' . date('YmdHis');
    // }
}
