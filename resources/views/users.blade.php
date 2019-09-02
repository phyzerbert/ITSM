@extends('layouts.dashboard')
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-users"></i>&nbsp;User Management</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Users</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="btn-group mb-3 float-right">
                    <a class="btn btn-info btn-sm" href="#" id="btn-add" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add New"><i class="fa fa-lg fa-plus"></i>Add New</a>
                </div>
                <div class="tile-body mt-3">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>UserID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ ($page_number-1) * 10 + $loop->index+1 }}</td>
                                <td class="username">{{$user->name}}</td>
                                <td class="firstname">{{$user->firstname}}</td>
                                <td class="lastname">{{$user->lastname}}</td>
                                <td class="gender">{{$user->gender}}</td>
                                <td class="phone">{{$user->phone}}</td>
                                <td class="role">{{$user->role}}</td>
                                <td class="py-2">
                                    <a href="{{route('user.delete', $user->id)}}" class="btn btn-primary btn-sm btn-delete" onclick="return confirm('Are you sure?');" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"><i class="fa fa-trash-o" style="font-size:20px"></i>&nbsp;Delete</a>
                                    <a href="#" class="btn btn-info btn-sm btn-edit" data-value="{{$user->id}}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"><i class="fa fa-edit" style="font-size:20px"></i>Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="pull-left" style="margin: 0;">
                            <p>Total <strong style="color: red">{{ $users->total() }}</strong> users</p>
                        </div>
                        <div class="pull-right" style="margin: 0;">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="userModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create User</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="" id="create_form" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label class="control-label">User ID</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Username">
                        <span id="name_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First Name">
                        <span id="firstname_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last Name">
                        <span id="lastname_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span id="gender_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone Number">
                            <span id="phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    <div class="form-group">
                        <label class="control-label">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="User">User</option>
                            <option value="Admin">Administrator</option>
                        </select>
                    </div>

                    <div class="form-group password-field">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <span id="password_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group password-field">
                        <label class="control-label">Password Confirm</label>
                        <input type="password" name="password_confirmation" id="confirmpassword" class="form-control" placeholder="Password Confirm">
                        <span id="confirmpassword_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>&nbsp;Save</button>
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
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="" id="edit_form" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" />
                    <div class="form-group">
                        <label class="control-label">User ID</label>
                        <input class="form-control" type="text" name="name" id="edit_name" placeholder="Username">
                        <span id="edit_name_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control" type="text" name="firstname" id="edit_firstname" placeholder="First Name">
                        <span id="edit_firstname_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input class="form-control" type="text" name="lastname" id="edit_lastname" placeholder="Last Name">
                        <span id="edit_lastname_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <select class="form-control" name="gender" id="edit_gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span id="edit_gender_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control" type="text" name="phone" id="edit_phone" placeholder="Phone Number">
                            <span id="edit_phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    <div class="form-group">
                        <label class="control-label">Role</label>
                        <select class="form-control" name="role" id="edit_role">
                            <option value="User">User</option>
                            <option value="Admin">Administrator</option>
                        </select>
                        <span id="edit_role_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group password-field">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password">
                        <span id="edit_password_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group password-field">
                        <label class="control-label">Password Confirm</label>
                        <input type="password" name="password_confirmation" id="edit_confirmpassword" class="form-control" placeholder="Password Confirm">
                        <span id="edit_confirmpassword_error" class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>&nbsp;Save</button>
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
            $("#userModal").modal();
        });

        $("#btn_create").click(function(){          
            $.ajax({
                url: "{{route('user.create')}}",
                type: 'post',
                dataType: 'json',
                data: $('#create_form').serialize(),
                success : function(data) {
                    console.log(data);
                    if(data == 'success') {
                        alert('Created user successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#name_error').show();
                            $('#create_form #name').focus();
                        }

                        if(messages.firstname) {
                            $('#firstname_error strong').text(data.responseJSON.errors.firstname[0]);
                            $('#firstname_error').show();
                            $('#firstname_form #firstname').focus();
                        }

                        if(messages.lastname) {
                            $('#lastname_error strong').text(data.responseJSON.errors.lastname[0]);
                            $('#lastname_error').show();
                            $('#create_form #lastname').focus();
                        }

                        if(messages.password) {
                            $('#password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#password_error').show();
                            $('#create_form #password').focus();
                        }

                        if(messages.phone) {
                            $('#phone_error strong').text(data.responseJSON.errors.phone[0]);
                            $('#phone_error').show();
                            $('#create_form #phone').focus();
                        }
                    }
                }
            });
        });

        $(".btn-edit").click(function(){
            let user_id = $(this).attr("data-value");
            let username = $(this).parents('tr').find(".username").text().trim();
            let firstname = $(this).parents('tr').find(".firstname").text().trim();
            let lastname = $(this).parents('tr').find(".lastname").text().trim();
            let phone = $(this).parents('tr').find(".phone").text().trim();
            let gender = $(this).parents('tr').find(".gender").text().trim();
            let role = $(this).parents('tr').find(".role").text().trim();            

            $("#edit_form input.form-control").val('');
            $("#editModal #edit_id").val(user_id);
            $("#editModal #edit_name").val(username);
            $("#editModal #edit_firstname").val(firstname);
            $("#editModal #edit_lastname").val(lastname);
            $("#editModal #edit_gender").val(gender);
            $("#editModal #edit_phone").val(phone);
            $("#editModal #edit_role").val(role);  


            $("#editModal").modal();
        });

        $("#btn_update").click(function(){
            $.ajax({
                url: "{{route('user.edit')}}",
                type: 'post',
                dataType: 'json',
                data: $('#edit_form').serialize(),
                success : function(data) {
                    console.log(data);
                    if(data == 'success') {
                        alert('Updated user successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#edit_name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#edit_name_error').show();
                            $('#edit_form #edit_name').focus();
                        }

                        if(messages.firstname) {
                            $('#edit_firstname_error strong').text(data.responseJSON.errors.firstname[0]);
                            $('#edit_firstname_error').show();
                            $('#edit_form #edit_firstname').focus();
                        }

                        if(messages.lastname) {
                            $('#edit_lastname_error strong').text(data.responseJSON.errors.lastname[0]);
                            $('#edit_lastname_error').show();
                            $('#edit_form #edit_lastname').focus();
                        }

                        if(messages.password) {
                            $('#edit_password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#edit_password_error').show();
                            $('#edit_form #edit_password').focus();
                        }

                        if(messages.phone) {
                            $('#edit_phone_error strong').text(data.responseJSON.errors.phone[0]);
                            $('#edit_phone_error').show();
                            $('#edit_form #edit_phone').focus();
                        } 
                        if(messages.gender) {
                            $('#edit_gender_error strong').text(data.responseJSON.errors.gender[0]);
                            $('#edit_gender_error').show();
                            $('#edit_form #edit_gender').focus();
                        }                  

                    }
                }
            });
        });

    });
</script>
@endsection