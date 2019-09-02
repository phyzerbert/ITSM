@extends('layouts.dashboard')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-database"></i>&nbsp;Knowledge Base</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Knowledge Base</a></li>
        </ul>
    </div>
    <div class="">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="tile">
                    <div class="tile-header">
                        <h3 class="float-left">Knowledge Base Solution</h3>
                        <h3 class="float-right"><a href="{{route('kdb.index')}}"><i class="fa fa-reply"></i>&nbsp;Return</a></h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tile-body mt-3">
                        <h3><span>Problem : </span>{{$problem->problem}}</h3>
                        <h3>Solution :</h3>
                        <textarea name="name" class="form-control" rows="6" cols="80" readonly>{{$problem->solution}}</textarea>
                        <!-- <pre class="ml-5" style="font-size:16px">{{$problem->solution}}</pre>                         -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
