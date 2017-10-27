<?php

namespace App\Http\Controllers;

use App\DataTables\PendonorsDataTable;
use App\Pendonor;
use Charts;

class PendonorController extends Controller
{
    public function index(PendonorsDataTable $dataTable)
    {
        $gol = Pendonor::all();
        $goldar = Pendonor::groupBy('goldar')->select('goldar')->pluck('goldar');
        $golongan = Charts::database($gol, 'pie', 'highcharts')
                    ->title('Chart Pendonor Berdasarkan Golongan Darah')
                    ->colors(['#2196F3', '#F44336', '#FFC107', 'teal'])
                    ->groupBy('goldar');
        $jk = Charts::database($gol, 'pie', 'highcharts')
                    ->title('Chart Pendonor Berdasarkan Jenis Kelamin')
                    ->groupBy('jenis_kelamin');

        return $dataTable->render('pendonor._all', compact('goldar', 'golongan', 'jk'));
    }
}
