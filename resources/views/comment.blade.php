@extends('layouts.dashboard')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-folder-open"></i>&nbsp;Leave Comment to Incident</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Leave Comment</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mx-auto">
                <div class="tile">
                    <h3 class="tile-title">Incident</h3>
                    <hr>
                    <div class="tile-body">
                        <h6>Reference Number : <span class="text-primary">{{$incident->reference_number}}</span></h6>
                        <h6>Category : <span class="text-primary">{{$incident->category->name ?? ''}}</span></h6>
                        <h6>Assignment Group : <span class="text-primary">{{$incident->group->name ?? ''}}</span></h6>
                        <h6>Short Description : </h6>
                        <p class="pl-3">{{$incident->short_description}}</p>
                        <h6>Fault Description : </h6>
                        <p class="pl-3"><pre class="pl-3" style="font-size:14px;">{{$incident->description}}</pre></p>
                        <br>
                        <form action="{{route('incident.save_comment')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$incident->id}}" />
                            <div class="form-group">
                                <select class="form-control from" name="status" id="status">
                                    <option value="0">Pending</option>
                                    <option value="1" selected>Work In Process</option>                                
                                    <option value="2">Resolve</option>                                
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="content" id="" cols="30" rows="3" class="form-control" placeholder="Leave Comment ..."></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Save</button>
                                <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <h5>Comments </h5>
                @foreach ($incident->comments as $item)
                    <div class="tile p-2 mb-3">
                        <div class="tile-body p-3 border">
                            <div class="clearfix">
                                <h6 class="float-left text-primary">{{$item->user->name}}</h6>
                                <span class="float-right">{{$item->created_at}}</span>
                            </div>
                            <pre class="mb-0" style="font-size:13px;">{{$item->content}}</pre>
                        </div>
                    </div>
                @endforeach 
            </div>           
        </div>
    </div>
@endsection
