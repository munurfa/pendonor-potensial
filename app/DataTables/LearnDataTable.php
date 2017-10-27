<?php

namespace App\DataTables;

use Excel;
use Yajra\Datatables\Services\DataTable;

class LearnDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->collection($this->query())
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Excel::load(storage_path('sample/DtLearning.csv'), function ($reader) {
        })->get();

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->parameters($this->getParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'kode', 'nama', 'jk', 'goldar', 'umur', 'r', 'f', 'm', 'c',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'learndatatables_'.time();
    }

    protected function getParameters()
    {
        return [
            'order' => [[1, 'asc']],
            'pageLength' => 5,
        ];
    }
}
