@extends('layouts.dashboard')
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-object-group"></i>&nbsp;Group Management</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Group</a></li>
    </ul>
</div>
<div class="container">
    <div class="text-right">
        <button id="btn-add" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Add Group</button>
    </div>
    <div class="row mt-5">
        @foreach ($data as $item)           
            <div class="col-sm-6 col-md-3">
                <div class="tile">
                    <div class="tile-header text-right">
                        <a class="btn btn-sm btn-primary btn-edit" href="#" data-id="{{$item->id}}" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-lg fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="{{route('group.delete', $item->id)}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return window.confirm('Are you sure?')"><i class="fa fa-lg fa-trash"></i></a>
                    </div>
                    <div class="tile-body mt-3 py-4">
                        <h3 class="text-center">{{$item->name}}</h1>
                    </div>
                </div>
            </div> 
        @endforeach
    </div>
</div>

<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Group</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="{{route('group.create')}}" id="create_form" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Name" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>&nbsp;Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Group</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="{{route('group.edit')}}" id="edit_form" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" />
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input class="form-control" type="text" name="name" id="edit_name" placeholder="Name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>&nbsp;Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $("#btn-add").click(function(){
            $("#create_form input.form-control").val('');
            $("#createModal").modal();
        });

        $(".btn-edit").click(function(){
            let id = $(this).attr("data-id");
            let name = $(this).data("name");          

            $("#edit_form input.form-control").val('');
            $("#editModal #edit_id").val(id);
            $("#editModal #edit_name").val(name);

            $("#editModal").modal();
        });

    });
</script>
@endsection