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
                    <form role="form_validation" id="edit_user_form" method="POST" action="{{ action('UsersController@update', $user->id) }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{!! isset($user) ? $user->name : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="{!! isset($user) ? $user->email : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="cnic_or_passport_number">CNIC OR Passport Number</label>
                                <input type="text" class="form-control" name="cnic_or_passport_number" id="cnic_or_passport_number" placeholder="Enter CNIC or passport number" value="{!! isset($user) ? $user->cnic_or_passport_number : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                 <input type="text" class="form-control" name="phone_number" id="phone_number" data-inputmask='"mask": "(0999) 99-99-999"' data-mask placeholder="Enter phone number" value="{!! isset($user) ? $user->phone_number : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="file">Select Image</label>
                                <input type="file" id="file" name="file" onchange="return showImage(this)">
                            </div>
                            @if(isset($user) && $user->avatar_name)
                                <img src="{{ asset('user_avatars/'.$user->avatar_name) }}" id="show_image" style="height: 65px;">
                            @else
                                <img src="" id="show_image" style="height: 65px;">
                            @endif
                             <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="verified" value="1" id="verified" @if(isset($user) && $user->verified) checked @endif> Verified
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
        $("#edit_user_form").validate();
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