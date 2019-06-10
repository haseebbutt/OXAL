@extends('app')
@section('content')
@section('css')

@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>Users</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add User</h3>
                    </div>
                    <form role="form_validation" id="add_user_form" method="POST" action="{{ action('UsersController@store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="cnic_or_passport_number">CNIC OR Passport Number</label>
                                <input type="text" class="form-control" name="cnic_or_passport_number" id="cnic_or_passport_number" placeholder="Enter CNIC or passport number" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                 <input type="text" class="form-control" name="phone_number" id="phone_number" data-inputmask='"mask": "(0999) 99-99-999"' data-mask placeholder="Enter phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <label for="file">Select Image</label>
                                <input type="file" id="file" name="file" onchange="return showImage(this)">
                            </div>
                            <img src="" id="show_image" style="height: 65px;">
                             <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="verified" id="verified"> Verified
                                </label>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add_user_form").validate();
        $('#phone_number').inputmask();

    });

    function showImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#show_image').attr('src', e.target.result).height(65).width(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection