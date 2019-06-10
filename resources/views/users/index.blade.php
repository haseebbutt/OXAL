@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>Users</h1>
    </section>
    <section class="content-header">
        <a href="{!! url('admin/users/add') !!}" class="btn btn-primary">Add New User</a>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cnic Or Passport</th>
                                    <th>Phone Number</th>
                                    <th>Phone Number Verified</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->cnic_or_passport_number }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>@if($user->verified) Yes @else No @endif</td>
                                    <td>@if($user->verified) Admin @else Simple User @endif</td>
                                    <td>
                                        <a href="{!! url('admin/users/reviews/'.$user->id) !!}" class="btn btn-info btn-sm">Reviews</a>
                                        <a href="{!! url('admin/users/edit/'.$user->id) !!}" class="btn btn-primary btn-sm">Edit</a>
                                        <a class="btn btn-danger btn-sm" id="delete_button_{{ $user->id }}" userId = "{{ $user->id }}" onclick="deleteFormSubmit(this)">Delete</a>
                                        <form id="delete_user_form_{{ $user->id }}" action="{{ action('UsersController@delete', $user->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cnic Or Passport</th>
                                    <th>Phone Number</th>
                                    <th>Phone Number Verified</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable();

    });
    function deleteFormSubmit(input) {
        var userId = $(input).attr('userId');
        var result = confirm("Want to delete?");
        if (result) {
            $("#delete_user_form_"+userId).submit();

        }
    }
</script>
@endsection