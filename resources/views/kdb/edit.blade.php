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
                        <h3>Edit Article</h3>
                    </div>
                    <div class="tile-body">
                        <form method="post" action="{{route('kdb.update')}}">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{$kdb->id}}">
                                <div class="col-md-12 mb-4">
                                    <label>Knowledge Base Number</label>
                                    <input class="form-control" type="text" name="kb_number" id="kb_number" value="{{$kdb->kb_number}}" readonly>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 mb-4">
                                    <label>Category</label>
                                    <select name="category" id="category" class="form-control">
                                        @foreach ($category as $item)
                                            <option value="{{$item->id}}" @if($kdb->category_id == $item->id) selected @endif>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 mb-4">
                                    <label>Problem</label>
                                    <input class="form-control" type="text" name="problem" value="{{$kdb->problem}}" id="problem" />
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 mb-4">
                                    <label>Solution</label>
                                    <textarea class="form-control" name="solution" id="solution" rows="5" placeholder="Type Solution...">{{$kdb->solution}}</textarea>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-md-12">
                                    <a href="{{route('kdb.index')}}" class="btn btn-danger float-right"><i class="fa fa-fw fa-lg fa-undo"></i> Back</a>
                                    <button class="btn btn-primary float-right mr-2" id="profile-submit" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
