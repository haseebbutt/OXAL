@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>Products</h1>
    </section>
    <section class="content-header">
        <a href="{!! url('admin/products/add') !!}" class="btn btn-primary">Add New Product</a>
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
                                    <th>Title</th>
                                    <th>Condition</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Provience</th>
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Longitude</th>
                                    <th>Laptitude</th>
                                    <th>Featured</th>
                                    <th>Sold</th>
                                    <th>Category</th>
                                    <th>Added By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->condition }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->province }}</td>
                                    <td>{{ $product->city }}</td>
                                    <td>{{ $product->area }}</td>
                                    <td>{{ $product->longitude }}</td>
                                    <td>{{ $product->laptitude }}</td>
                                    <td>@if($product->featured) Yes @else No @endif</td>
                                    <td>@if($product->sold) Yes @else No @endif</td>
                                    <td>{{ $product->category->title }}</td>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>
                                        <!-- <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a> -->
                                        <a href="{!! url('admin/products/edit/'.$product->id) !!}" class="btn btn-primary btn-sm">Edit</a>
                                        <a class="btn btn-danger btn-sm" id="delete_button_{{ $product->id }}" productId = "{{ $product->id }}" onclick="deleteFormSubmit(this)">Delete</a>
                                        <form id="delete_product_form_{{ $product->id }}" action="{{ action('ProductsController@delete', $product->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Condition</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Provience</th>
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Longitude</th>
                                    <th>Laptitude</th>
                                    <th>Featured</th>
                                    <th>Sold</th>
                                    <th>Category</th>
                                    <th>Added By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
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
        $('#example1').DataTable({
            "scrollX": true
        });
    });

    function deleteFormSubmit(input) {
        var productId = $(input).attr('productId');
        var result = confirm("Want to delete?");
        if (result) {
            $("#delete_product_form_"+productId).submit();

        }
    }
</script>
@endsection