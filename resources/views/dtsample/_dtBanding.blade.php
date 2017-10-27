<h3>DATA BANDING |
<a data-toggle="tab" href="#data" class="btn btn-sm btn-primary">DATA</a>
<a data-toggle="tab" href="#nilai" class="btn btn-sm btn-primary">CHART PENDONOR POTENSIAL</a>
<a href="{{url('/proses-hitung/banding')}}" class="btn btn-sm btn-primary" target="_blank">PROSES HITUNG</a>
</h3>
<br>
<div class="tab-content">
    <div id="data" class="tab-pane fade in active">
        <form action="" class="form-inline" id="cari-pot" method="POST">
            {{csrf_field()}}
            <label>Cari Berdasarkan Potensial/Tidak </label>
            <select name="pot" id="seleksi-pot" class="form-control">
                <option value="">SEMUA PENDONOR</option>
                @foreach($pot as $p)
                <option value="{{$p}}">{{$p}}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Cari</button>
        </form><br>
        <div class="table-responsive">
            {!! $dataTable->table(['class' => 'table table-hover table-bordered']) !!}
        </div>
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
<script>
$('#cari-pot').on('submit', function(e) {
window.LaravelDataTables["dataTableBuilder"].draw();
e.preventDefault();
});
</script>
{!! Charts::scripts(['highcharts']) !!}
{!! $nilai->script() !!}
@endpush
