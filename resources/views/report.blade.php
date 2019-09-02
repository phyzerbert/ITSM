@extends('layouts.dashboard')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-excel-o"></i>&nbsp;Report Incidents</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Report Incidents</a></li>
        </ul>
    </div>
    <div class="">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="tile">
                    <div class="tile-header clearfix">                     
                        <h3 class="tile-title">Report Incidents</h3>                    
                        <form class="form-inline float-left" id="search_form" action="" method="POST">
                            @csrf
                            <input class="form-control form-control-sm ml-3" type="text" id="username" name="username" value="{{$username}}" placeholder="User ID">
                            <select class="form-control form-control-sm ml-2" id="status" name="status">
                                <option value="">Status</option>
                                <option value="0" @if($status == "0") selected @endif>Pending</option>
                                <option value="1" @if($status == "1") selected @endif>Working In Process</option>
                                <option value="2" @if($status == "2") selected @endif>Resolved</option>
                            </select>
                            <input class="form-control form-control-sm ml-2" type="text" id="opened_at" name="opened_at" value="{{$opened_at}}" autocomplete="off" placeholder="Opened Date" />
                            <input class="form-control form-control-sm ml-2" type="text" id="resolved_at" name="resolved_at" value="{{$resolved_at}}" autocomplete="off" placeholder="Resolved Date" />
                            <button class="btn btn-primary btn-sm ml-4" type="submit" onclick="search()"><i class="fa fa-fw fa-lg fa-search"></i>Search</button>                           
                            <button class="btn btn-danger btn-sm ml-4" type="button" id="btn-reset"><i class="fa fa-fw fa-lg fa-eraser"></i>Reset</button>                           
                        </form>                       
                        <button class="btn btn-info btn-sm ml-4 float-right" type="button" id="btn-export"><i class="fa fa-fw fa-lg fa-file-excel-o"></i>Export</button>                              
                    </div>
                    <div class="tile-body mt-3">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center" id="documentTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User ID</th>
                                        <th>Short Description</th>
                                        <th>Preority</th>
                                        <th>Status</th>
                                        <th>Assignment Group</th>
                                        <th>Resolved By</th>
                                        <th>Opened Date</th>
                                        <th>Resolved Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                            <td class="username">@isset($item->user) {{$item->user->name}} @endisset</td>
                                            <td class="description">{{$item->description}}</td>
                                            <td class="urgency">
                                                @if($item->urgency == "0")
                                                    <span class="badge badge-danger">Low</span>
                                                @else
                                                    <span class="badge badge-primary">High</span>
                                                @endif
                                            </td>
                                            <td class="status" data-value="{{$item->status}}">
                                                @if ($item->status == 0) 
                                                    <span class="badge badge-danger">Pending</span>
                                                @elseif($item->status == 1) 
                                                    <span class="badge badge-primary">Work In Process</span>                                                     
                                                @else 
                                                    <span class="badge badge-success">Resolve</span>                                                     
                                                @endif
                                            </td>
                                            <td class="">@isset($item->group->name){{$item->group->name}}@endisset</td>
                                            <td class="">@isset($item->resolved_user->name){{$item->resolved_user->name}}@endisset</td>
                                            <td class="opened_at">{{date('m/d/Y H:i', strtotime($item->created_at))}}</td>
                                            <td class="">@if($item->resolved_at){{date('m/d/Y H:i', strtotime($item->resolved_at))}}@endif</td>
                                        </tr>
                                    @endforeach                 
                                </tbody>
                            </table>
                            <div class="clearfix">
                                <div class="pull-left" style="margin: 0;">
                                    <p>Total <strong style="color: red">{{ $data->total() }}</strong> Incidents</p>
                                </div>
                                <div class="pull-right" style="margin: 0;">
                                    {!! $data->links() !!}
                                </div>
                            </div>
                        </div>                        
                    </div>                   
                </div>
            </div>            
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('main/js/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('main/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script>
        function search(){
            $("#search_form").attr('action', '');
        }
        $(function(){
            $("#opened_at").dateRangePicker();
            $("#resolved_at").dateRangePicker();
            $("#btn-reset").click(function(){
                $("#username").val('');
                $("#status").val('');
                $("#opened_at").val('');
                $("#resolved_at").val('');
            });
            $("#btn-export").click(function(){
                $("#search_form").attr('action', "{{route('incident.export')}}").submit();
            })
        });
    </script>    
@endsection
