@extends('layouts.dashboard')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-folder-open"></i>&nbsp;Search an Incident(s)</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Search an Incident(s)</a></li>
        </ul>
    </div>
    {{-- @php
        dump($urgency);
    @endphp --}}
    <div class="">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="tile">
                    <div class="tile-header">                     
                        <h3 class="tile-title">Search an Incident(s)</h3>                    
                        <form class="form-inline" id="search_form" action="{{route("incident.search")}}" method="POST">
                            @csrf
                            <label class="control-label">User ID</label>
                            <input class="form-control form-control-sm ml-3" type="text" id="username" name="username" value="{{$username}}" placeholder="User ID">
                            <label class="control-label ml-3">First Name</label>
                            <input class="form-control form-control-sm ml-3" type="text" id="firstname" name="firstname" value="{{$firstname}}" placeholder="First Name">
                            <label class="control-label ml-3">Last Name</label>
                            <input class="form-control form-control-sm ml-3" type="text" id="lastname" name="lastname" value="{{$lastname}}" placeholder="Last Name">                        
                            <label class="control-label ml-3">Phone Number</label>
                            <input class="form-control form-control-sm ml-2" type="text" id="phone" name="phone" value="{{$phone}}" placeholder="Phone Number">
                            <label class="control-label ml-3">Description</label>
                            <input class="form-control form-control-sm ml-2" type="text" id="description" name="description" value="{{$description}}" placeholder="Description" />
                            <label class="control-label ml-3">Urgency</label>
                            <label class="form-check-label ml-3">
                                <input class="form-check-input" type="checkbox" id="urgency_low" name="urgency_low" @if ($urgency[0]=="on") checked @endif>Low
                            </label>
                            <label class="form-check-label ml-3">
                                <input class="form-check-input" type="checkbox" id="urgency_high" name="urgency_high" @if ($urgency[1]=="on") checked @endif>High
                            </label>
                            <button class="btn btn-primary btn-sm ml-4" type="submit" onclick="search()"><i class="fa fa-fw fa-lg fa-search"></i>Search Now</button>
                            
                        </form>                       
                    </div>
                    <div class="tile-body mt-3">
                        @csrf
                        <table class="table table-hover table-bordered text-center" id="documentTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Urgency</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    @if (Auth::user()->role == 'Admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incidents as $item)
                                    <tr>
                                        <td>{{ ($page_number-1) * 10 + $loop->index+1 }}</td>
                                        <td class="username">@isset($item->user) {{$item->user->name}} @endisset</td>
                                        <td class="firstname">@isset($item->user) {{$item->user->firstname}} @endisset</td>
                                        <td class="lastname">@isset($item->user) {{$item->user->lastname}} @endisset</td>
                                        <td class="phone">@isset($item->user) {{$item->user->phone}} @endisset</td>
                                        <td class="urgency">@if($item->urgency == "0") Low @else High @endif</td>
                                        <td class="">{{$item->description}}</td>
                                        <td class="status" data-value="{{$item->status}}">@if ($item->status == 0) Pending @elseif($item->status == 1) Work In Process @else Resolve @endif</td>
                                        <td class="comment">{{$item->comment}}</td>
                                        @if (Auth::user()->role == 'Admin')
                                            <td class="py-2">
                                                <a href="{{route('incident.delete', $item->id)}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash-o" style="font-size:18px"></i>Delete</a>
                                                <a href="#" class="btn btn-primary btn-sm btn-response" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Response"><i class="fa fa-edit" style="font-size:18px"></i>Response</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach                 
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="pull-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $incidents->total() }}</strong> Incidents</p>
                            </div>
                            <div class="pull-right" style="margin: 0;">
                                {!! $incidents->links() !!}
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>            
        </div>
    </div>
    <div class="modal fade" id="responseModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('incident.response')}}" id="response_form" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Response</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="incident_id" />
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control from" name="status" id="status">
                                <option value="0">Pending</option>
                                <option value="1">Work In Process</option>                                
                                <option value="2">Resolve</option>                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea class="form-control" name="comment" id="comment"></textarea>
                        </div>

                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" id="btn_create" class="btn btn-primary"><i class="fa fa-fw fa-lg fa-check-circle"></i>&nbsp;Save</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function search(){
            let username = $("#username").val().trim();
            let firstname = $("#firstname").val().trim();
            let lastname = $("#lastname").val().trim();
            let phone = $("#phone").val().trim();
            let description = $("#description").val().trim();
            if (username == '' && firstname == '' && lastname == '' && phone == '' && description == '' && $("#urgency_high").prop('checked') != true && $("#urgency_low").prop('checked') != true) {
                alert("At least one field must be entered.");
                return false;
            }
        }
        $(function(){
            $(".btn-response").click(function(){
                let id = $(this).attr("data-id");
                let status = $(this).parents('tr').find('.status').data('value');
                let comment = $(this).parents('tr').find('.comment').text().trim();
                
                $("#response_form #incident_id").val(id);
                $("#response_form #status").val(status);
                $("#response_form #comment").val(comment);
                $("#responseModal").modal();
            })
        });
    </script>    
@endsection
