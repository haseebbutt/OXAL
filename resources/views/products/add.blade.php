@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>Products</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Product</h3>
                    </div>
                    <form role="form_validation" id="add_product_form" method="POST" action="{{ action('ProductsController@store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <input type="text" class="form-control" name="condition" id="condition" placeholder="Enter condition" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description" id="description" placeholder="Enter description" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Choose Category</label>
                                <select class="form-control select2" id="category_id" name="category_id" style="width: 100%;">
                                    <option value="" selected disabled>---Choose Category---</option>
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="form-group">
                                <label for="description">Choose User</label>
                                <select class="form-control select2" id="user_id" name="user_id" style="width: 100%;">
                                    <option value="" selected disabled>---Choose User---</option>
                                    @foreach($users as $key => $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" placeholder="Enter price" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Provience</label>
                                 <input type="text" class="form-control" name="province" id="province" placeholder="Enter phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="Enter city" required>
                            </div>

                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="area" class="form-control" name="area" id="area" placeholder="Enter area" required>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter longitude" required>
                            </div>
                            <div class="form-group">
                                <label for="laptitude">Laptitude</label>
                                <input type="text" class="form-control" name="laptitude" id="laptitude" placeholder="Enter laptitude" required>
                            </div>
                            <div class="form-group">
                                <label for="images">Choose Images</label>
                                <input type="file" class="form-control" name="images[]" id="images" placeholder="Choose images" multiple onchange="showMultipleImages(this);" required>
                                <br>
                                <div class="preview-area">
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="featured" id="featured"> Featured
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
<script src="{{ asset('js/select2-full.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add_product_form").validate();
        $('.select2').select2();
    });

    function showMultipleImages(input) {
        if(input.files) {
            $('#preview_area').html('');
            var fileList = input.files;
            var anyWindow = window.URL || window.webkitURL;
            for(var i = 0; i < fileList.length; i++) {
                var objectUrl = anyWindow.createObjectURL(fileList[i]);
                $('.preview-area').append('<img src="' + objectUrl + '" style="height: 65px; width: 100px;" />');
                window.URL.revokeObjectURL(fileList[i]);
            }
        }
    }

</script>
@endsection