@extends('app')
@section('content')
@section('css')

@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>Categories</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Category</h3>
                    </div>
                    <form role="form_validation" id="add_category_form" method="POST" action="{{ action('CategoriesController@store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" required>
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
        $("#add_category_form").validate();
    });
</script>
@endsection