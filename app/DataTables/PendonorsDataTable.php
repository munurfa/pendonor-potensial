<?php

namespace App\DataTables;

use App\Pendonor;
use Yajra\Datatables\Services\DataTable;

class PendonorsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('jumlah_donor', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->jumlah_donor.'</li>';
                })->implode(' ');
            })
            ->addColumn('tgl_donor', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->created_at->format('d M Y').'</li>';
                })->implode(' ');
            })
            ->addColumn('cc', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->CC.'</li>';
                })->implode(' ');
            })
            ->addColumn('total_donor', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->CC * $transaksi->jumlah_donor.'</li>';
                })->implode(' ');
            })
            ->addColumn('status_donor', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->status_donor.'</li>';
                })->implode(' ');
            })
            ->addColumn('trans_umur', function (Pendonor $pendonor) {
                return $pendonor->transaksi->map(function ($transaksi) {
                    return '<li>'.$transaksi->umur.'</li>';
                })->implode(' ');
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Pendonor::with(['transaksi' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->select('pendonors.*');
        if ($this->request()->get('goldar')) {
            $query->where('goldar', $this->request()->get('goldar'));
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
                                    d.goldar = $("select[name=gol]").val();
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
            'kode_pendonor' => ['data' => 'kode_pendonor', 'name' => 'kode_pendonor', 'orderable' => false],
            'nama' => ['data' => 'nama', 'name' => 'nama'],
            'jenis_kelamin' => ['data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
            'goldar' => ['data' => 'goldar', 'name' => 'goldar'],
            'trans_umur' => ['data' => 'trans_umur', 'name' => 'trans_umur',
                                'orderable' => false, 'searchable' => false, ],
            'status_donor' => ['data' => 'status_donor', 'name' => 'status_donor',
                                'orderable' => false, 'searchable' => false, ],
            'jumlah_donor' => ['data' => 'jumlah_donor', 'name' => 'jumlah_donor',
                                'orderable' => false, 'searchable' => false, ],
            'cc' => ['data' => 'cc', 'name' => 'cc',
                        'orderable' => false, 'searchable' => false, ],
            'total_donor' => ['data' => 'total_donor', 'name' => 'total_donor',
                                'orderable' => false, 'searchable' => false, ],
            'tgl_donor' => ['data' => 'tgl_donor', 'name' => 'tgl_donor',
                            'orderable' => false, 'searchable' => false, ],
            // add your columns
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pendonorssdatatables_'.time();
    }

    protected function getParameters()
    {
        return [
            'order' => [[1, 'asc']],
            'pageLength' => 5,
            'dom' => 'Bfrtip',
            'buttons' => ['csv', 'excel', 'pdf', 'print', 'reload'],
        ];
    }
}
