@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<style type="text/css">
    .img-wrap {
    position: relative;
    display: inline-block;
    border: 1px solid;
    font-size: 0;
}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 2px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: 0.5;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
}
.img-wrap:hover .close {
    opacity: 1;
}
</style>
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
                        <h3 class="box-title">Edit Product</h3>
                    </div>
                    <form role="form_validation" id="add_product_form" method="POST" action="{{ action('ProductsController@update', $product->id) }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{!! isset($product) ? $product->title : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <input type="text" class="form-control" name="condition" id="condition" placeholder="Enter condition" value="{!! isset($product) ? $product->condition : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description" id="description" placeholder="Enter description" value="{!! isset($product) ? $product->description : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Choose Category</label>
                                <select class="form-control select2" id="category_id" name="category_id" style="width: 100%;">
                                    <!-- <option value="" selected disabled>---Choose Category---</option> -->
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="form-group">
                                <label for="description">Choose User</label>
                                <select class="form-control select2" id="user_id" name="user_id" style="width: 100%;">
                                    <!-- <option value="" selected disabled>---Choose User---</option> -->
                                    @foreach($users as $key => $user)
                                        <option value="{{ $user->id }}" @if($product->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" placeholder="Enter price" value="{!! isset($product) ? $product->price : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Provience</label>
                                 <input type="text" class="form-control" name="province" id="province" placeholder="Enter province" value="{!! isset($product) ? $product->province : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="Enter city" value="{!! isset($product) ? $product->city : '' !!}" required>
                            </div>

                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="area" class="form-control" name="area" id="area" placeholder="Enter area" value="{!! isset($product) ? $product->area : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter longitude" value="{!! isset($product) ? $product->longitude : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="laptitude">Laptitude</label>
                                <input type="text" class="form-control" name="laptitude" id="laptitude" placeholder="Enter laptitude" value="{!! isset($product) ? $product->laptitude : '' !!}" required>
                            </div>
                            <div class="form-group">
                                <label for="images">Choose Images</label>
                                <input type="file" class="form-control" name="images[]" id="images" placeholder="Choose images" multiple onchange="showMultipleImages(this);">
                                <br>
                                <div id="preview_area">
                                </div>
                                @foreach($product->images as $key => $image)
                                <!-- <img src="{{ asset('product_images/'.$image->name) }}" style="height: 65px; width: 100px;"> -->
                                <div class="img-wrap" id="image_wrap_id_{{ $image->id }}">
                                    <span class="close delete_image" imageId="{{ $image->id }}" imageNumber="{{ $key+1 }}">&times;</span>
                                    <img src="{{ asset('product_images/'.$image->name) }}" id="image_{{ $image->id }}" style="height: 65px; width: 100px;">
                                </div>
                                @endforeach
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="featured" id="featured" @if($product->featured) checked @endif> Featured
                                </label>
                            </div>
                            <select id="images_to_delete" name="images_to_delete[]" multiple hidden></select>
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

        $('.delete_image').on('click', function(e) {
            e.preventDefault();
            //var id = $(this).closest('.img-wrap').find('img').data('id');
            var imageId = $(this).attr('imageId');
            var imageNumber = $(this).attr('imageNumber');
            var result = confirm("Do you Want to delete this image?");
            if (result) {
                $("#image_wrap_id_"+imageId).remove();

                $('#images_to_delete')
                        .append($("<option></option>")
                        .attr("value", imageId)
                        .attr("selected", true)
                        .text(imageId)); 
            }
        });

    });

    function showMultipleImages(input) {
        if(input.files) {
            $('#preview_area').html('');
            var fileList = input.files;
            var anyWindow = window.URL || window.webkitURL;
            for(var i = 0; i < fileList.length; i++) {
                var objectUrl = anyWindow.createObjectURL(fileList[i]);
                $('#preview_area').append('<img src="' + objectUrl + '" style="height: 65px; width: 100px;" />');
                window.URL.revokeObjectURL(fileList[i]);
            }
        }
    }

</script>
@endsection