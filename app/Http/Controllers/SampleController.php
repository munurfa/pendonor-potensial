<?php

namespace App\Http\Controllers;

use App\DataTables\BandingDataTable;
use App\DataTables\LearnDataTable;
use App\DataTables\TestDataTable;
use App\DataTables\TrainDataTable;
use App\DtLearn;
use Charts;
use Excel;

class SampleController extends Controller
{
    public function learning(LearnDataTable $dataTable)
    {
        $data = 'dtsample._dtLearn';
        $query = Excel::load(storage_path('sample/DtLearning.csv'), function ($reader) {
        })->get();
        $nilai = Charts::create('pie', 'highcharts')
                    ->title('Chart Data Learning Berdasarkan Nilai C')
                    ->labels(['C = 0', 'C = 1'])
                    ->values([$query->where('c', 0.0)->count(),
                            $query->where('c', 1.0)->count(), ]);

        return $dataTable->render('dtsample.index', compact('data', 'nilai'));
    }

    public function training(TrainDataTable $dataTable)
    {
        $data = 'dtsample._dtTrain';
        $query = Excel::load(storage_path('sample/DtTraining.csv'), function ($reader) {
        })->get();
        $multiplied = \App\DtLearn::csv($query);
        $nilai = Charts::create('pie', 'highcharts')
                    ->title('Chart Data Training Berdasarkan Potensial/Tidak')
                   ->labels(['POTENSIAL', 'TIDAK'])
                    ->values([$multiplied->where('hasilpotensi', 'POTENSIAL')->count(),
                            $multiplied->where('hasilpotensi', 'TIDAK')->count(), ]);

        return $dataTable->render('dtsample.index', compact('data', 'nilai'));
    }

    public function testing(TestDataTable $dataTable)
    {
        $data = 'dtsample._dtTest';
        $query = Excel::load(storage_path('sample/DtTesting.csv'), function ($reader) {
        })->get();
        $multiplied = \App\DtLearn::csv($query);
        $nilai = Charts::create('pie', 'highcharts')
                    ->title('Chart Data Testing Berdasarkan Potensial/Tidak')
                   ->labels(['POTENSIAL', 'TIDAK'])
                    ->values([$multiplied->where('hasilpotensi', 'POTENSIAL')->count(),
                            $multiplied->where('hasilpotensi', 'TIDAK')->count(), ]);

        return $dataTable->render('dtsample.index', compact('data', 'nilai'));
    }

    public function banding(BandingDataTable $dataTable, $tglDt = null)
    {
        $ban = (null == DtLearn::all()->first()) ? '2017-01' : substr(DtLearn::all()->first()->created_at, 0, 7);
        if (null == $tglDt) {
            $tglDt = $ban;
        } else {
            $tglDt = $tglDt;
        }
        DtLearn::selban($tglDt);
        $data = 'dtsample._dtBanding';
        $query = DtLearn::all();
        $nilai = Charts::database($query, 'pie', 'highcharts')
                    ->title('Chart Data Banding Berdasarkan Potensial/Tidak')
                    ->groupBy('hasilpotensi');
        $pot = $query->groupBy('hasilpotensi')->pluck('0')->pluck('hasilpotensi');

        return $dataTable->render('dtsample.index', compact('data', 'nilai', 'c45', 'pot'));
    }

    public function proses($data)
    {
        $dt = ['', 'training', 'testing', 'banding'];
        if (array_search($data, $dt)) {
            if ('training' == $data) {
                $query = Excel::load(storage_path('sample/DtTraining.csv'), function ($reader) {
                })->get();
                $proses = \App\DtLearn::csv($query);
            } elseif ('testing' == $data) {
                $query = Excel::load(storage_path('sample/DtTesting.csv'), function ($reader) {
                })->get();
                $proses = \App\DtLearn::csv($query);
            } elseif ('banding' == $data) {
                $proses = DtLearn::all();
            }
        } else {
            return view('errors/404');
        }
        $c45 = $this->c45($proses);

        return view('proses/_hitung', compact('proses', 'data', 'c45'));
    }

    protected function c45($query)
    {
        $allCount = $query->count();
        $tposT = $query->sum(function ($item) {return $item['potensial']['tpT']; });
        $tnegT = $query->sum(function ($item) {return $item['potensial']['tnT']; });
        $fposT = $query->sum(function ($item) {return $item['potensial']['fpT']; });
        $fnegT = $query->sum(function ($item) {return $item['potensial']['tnT']; });

        $data['akurasiT'] = ($tposT + $tnegT) / $allCount;
        $data['erroetT'] = ($fposT + $fnegT) / $allCount;
        if ((0 == $fnegT) && (0 == $tposT)) {
            $data['recallT'] = 0;
        } else {
            $data['recallT'] = $tposT / ($fnegT + $tposT);
        }

        if ((0 == $fposT) && (0 == $tposT)) {
            $data['presisiT'] = 0;
        } else {
            $data['presisiT'] = $tposT / ($fposT + $tposT);
        }

        return $data;
    }
}
