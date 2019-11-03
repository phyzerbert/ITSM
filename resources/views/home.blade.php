@extends('layouts.dashboard')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-folder-open"></i>&nbsp;Create New Incident</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Create New Incident</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="tile">
                    <h3 class="tile-title">Create New Incident</h3>                    
                    <form action="{{route("incident.create")}}" method="POST">
                        @csrf
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label">User ID</label>
                                <input class="form-control" type="text" name="userid" value="{{Auth::user()->name}}" readonly placeholder="User ID">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Phone Number</label>
                                <input class="form-control" type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="Phone Number">
                            </div> 
                            @php
                                $groups = \App\Group::all();
                            @endphp
                            <div class="form-group">
                                <label for="group" class="control-label">Group</label>
                                <select name="group_id" id="group" class="form-control" required>
                                    @foreach ($groups as $item)
                                        <option value="{{$item->id}}" @if($item->name == 'IT HelpDesk') selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $groups = \App\Category::all();
                            @endphp
                            <div class="form-group">
                                <label for="category" class="control-label">Category</label>
                                <select name="category_id" id="category" class="form-control" required>
                                    @foreach ($groups as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Urgency</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="urgency" value="0" checked>Low
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="urgency" value="1">High
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group" class="control-label">Priority</label>
                                <select name="priority" id="priority" class="form-control" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Short Description</label>
                                <input class="form-control" type="text" name="short_description" placeholder="Short Description" />
                            </div> 
                            <div class="form-group">
                                <label class="control-label">Fault Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Fault Description"></textarea>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-danger" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>

@endsection
