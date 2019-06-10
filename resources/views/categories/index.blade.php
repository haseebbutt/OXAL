@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Categories
        </h1>
    </section>
    <section class="content-header">
        <a href="{!! url('admin/categories/add') !!}" class="btn btn-primary">Add New Category</a>
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
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>
                                        <a href="{!! url('admin/categories/edit/'.$category->id) !!}" class="btn btn-primary btn-sm">Edit</a>
                                        <a class="btn btn-danger btn-sm" id="delete_button_{{ $category->id }}" categoryId = "{{ $category->id }}" onclick="deleteFormSubmit(this)">Delete</a>
                                        <form id="delete_category_form_{{ $category->id }}" action="{{ action('CategoriesController@delete', $category->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
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
        $('#example1').DataTable()
    });
    function deleteFormSubmit(input) {
        var categoryId = $(input).attr('categoryId');
        var result = confirm("Want to delete?");
        if (result) {
            $("#delete_category_form_"+categoryId).submit();

        }
    }
</script>
@endsection