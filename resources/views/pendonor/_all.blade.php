@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">TRANSAKSI DONOR</div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#data">DATA TRANSAKSI</a></li>
                        <li><a data-toggle="tab" href="#gol-chart">CHART GOLONGAN DARAH</a></li>
                        <li><a data-toggle="tab" href="#jk-chart">CHART JENIS KELAMIN</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="data" class="tab-pane fade in active">
                            <form action="" class="form-inline" id="cari-goldar" method="POST">
                                {{csrf_field()}}
                                <label>Cari Berdasarkan Goldar</label>
                                <select name="gol" id="seleksi-goldar" class="form-control">
                                    <option value="">SEMUA GOLDAR</option>
                                    @foreach($goldar as $g)
                                        <option value="{{$g}}">{{$g}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </form><br>
                            {!! $dataTable->table() !!}
                        </div>
                        <div id="gol-chart" class="tab-pane fade in">
                            <center>
                                {!! $golongan->html() !!}
                            </center>
                        </div>
                        <div id="jk-chart" class="tab-pane fade in">
                            <center>
                                {!! $jk->html() !!}
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{asset('/css/buttons.dataTables.min.css')}}">
{!! Charts::styles(['highcharts', 'google']) !!}
@endpush

@push('script')
<script src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script>
{!! $dataTable->scripts() !!}
 <script>
$('#cari-goldar').on('submit', function(e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });
</script>
{!! Charts::scripts(['highcharts', 'google']) !!}
{!! $jk->script() !!}
{!! $golongan->script() !!}
@endpush
