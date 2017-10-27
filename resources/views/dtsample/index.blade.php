@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">DATA SAMPLE</div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li {!! (Request::path() == 'data-learning') ? 'class="active"' : '' !!}>
                            <a href="{{route('data.learning')}}">DATA LEARNING</a>
                        </li>
                        <li {!! (Request::path() == 'data-training') ? 'class="active"' : '' !!}>
                            <a href="{{route('data.training')}}">DATA TRAINING</a>
                        </li>
                        <li {!! (Request::path() == 'data-testing') ? 'class="active"' : '' !!}>
                            <a href="{{route('data.testing')}}">DATA TESTING</a>
                        </li>
                        <li {!! (Request::path() == 'data-banding') ? 'class="active"' : '' !!}>
                            <a href="{{route('data.banding')}}">DATA BANDING</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include($data)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
