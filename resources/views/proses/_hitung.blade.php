@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">PROSES HITUNG {{strtoupper($data)}}</div>
                <div class="panel-body">
                    @if(isset($c45))
                    <div class="bs-callout bs-callout-danger">
                        <h4>
                        <b>Akurasi :</b> {{ round((float)$c45['akurasiT']*100,2) }}% || <b>Error Rate :</b>  {{ round((float)$c45['erroetT']*100,2) }}%
                        </h4><br>
                        <h4><b>Recall :</b>  {{ round((float)$c45['recallT']*100,2) }}% || <b>Precision :</b>  {{ round((float)$c45['presisiT']*100,2) }}%</h4>
                    </div><br>
                    @endif
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Node</th>
                                <th></th>
                                <th></th>
                                <th>Jumlah Kasus</th>
                                <th>C=0</th>
                                <th>C=1</th>
                                <th>Entropy</th>
                                <th>Gain</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $allproses = 0; ?>
                            @foreach ($proses->chunk(250) as $chunk)
                            @foreach ($chunk as $k)
                            <?php
                            $allproses += $k['c'];
                            ?>
                            @endforeach
                            @endforeach
                            <?php $C1 = $allproses; ?>
                            <tr>
                                <td>1</td>
                                <td>Total</td>
                                <td></td>
                                <td>{{$allPro = $proses->count()}}</td>
                                <td>{{$ePro1 = $allPro-$C1}}</td>
                                <td>{{$ePro2 = $C1}}</td>
                                <?php
                                $enPro1 = (-$ePro1 / $allPro) * log($ePro1 / $allPro, 2);
                                $enPro2 = (-$ePro2 / $allPro) * log($ePro2 / $allPro, 2);
                                ?>
                                <td>{{$entotPro = $enPro1+$enPro2}}</td>
                                <td></td>
                            </tr>
                            @include('proses/attr/_jk')
                            @include('proses/attr/_goldar')
                            @include('proses/attr/_umur')
                            @include('proses/attr/_R')
                            @include('proses/attr/_F')
                            @include('proses/attr/_M')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
