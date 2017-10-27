<h3>DATA TESTING |
<a data-toggle="tab" href="#data" class="btn btn-sm btn-primary">DATA</a>
<a data-toggle="tab" href="#nilai" class="btn btn-sm btn-primary">CHART PENDONOR POTENSIAL</a>
<a href="{{url('/proses-hitung/testing')}}" class="btn btn-sm btn-primary" target="_blank">PROSES HITUNG</a>
</h3>
<br>
<div class="tab-content">
    <div id="data" class="tab-pane fade in active">
        {!! $dataTable->table() !!}
    </div>
    <div id="nilai" class="tab-pane fade in">
        <center>
        {!! $nilai->html() !!}
        </center>
    </div>
</div>
@push('style')
<link rel="stylesheet" href="{{asset('/css/buttons.dataTables.min.css')}}">
{!! Charts::styles(['highcharts']) !!}
@endpush
@push('script')
<script src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script>
{!! $dataTable->scripts() !!}
{!! Charts::scripts(['highcharts']) !!}
{!! $nilai->script() !!}
@endpush
