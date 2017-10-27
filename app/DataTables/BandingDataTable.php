<?php

namespace App\DataTables;

use App\DtLearn;
use Yajra\Datatables\Services\DataTable;

class BandingDataTable extends DataTable
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
            ->addColumn('no_hp', function (DtLearn $banding) {
                return '<a href="#">'.$banding->pendonor->no_hp.'</a>';
            })
             // ->filter(function () {
             //     if ($this->request()->has('hasilpotensi')) {
             //         $this->query()->where('hasilpotensi', "{$this->request()->get('hasilpotensi')}");
             //     }
             // })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = DtLearn::with('pendonor')->get()
                // ->where('hasilpotensi', "{$this->request()->get('hasilpotensi')}")
                ;
        if ($this->request()->has('hasilpotensi')) {
            $query = DtLearn::with('pendonor')->get()
                    ->where('hasilpotensi', "{$this->request()->get('hasilpotensi')}");
        }

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
                    ->ajax(['data' => 'function (d) {
                                    d.hasilpotensi = $("select[name=pot]").val();
                                }',
                            ])
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
            'kode', 'nama', 'jk', 'goldar', 'umur',
            'no_hp' => ['data' => 'no_hp', 'name' => 'no_hp', 'orderable' => false, 'searchable' => false],
              'r', 'f', 'm', 'c',
            'hasil_uji' => ['data' => 'huji', 'name' => 'huji', 'orderable' => false, 'searchable' => false],
            'hasilpotensi' => ['data' => 'hasilpotensi', 'name' => 'hasilpotensi', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'bandingdatatables_'.time();
    }

    protected function getParameters()
    {
        return [
            'order' => [[1, 'asc']],
            'pageLength' => 5,
            'dom' => 'Bfrtip',
            'buttons' => ['csv', 'excel', 'print', 'reload'],
        ];
    }
}
