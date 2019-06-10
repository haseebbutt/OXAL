@extends('app')
@section('content')
@section('css')
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
<div class="content-wrapper">
    <section class="content-header">
        <h1>All Reviews</h1>
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
                                    <th>id</th>
                                    <th>Reviewer Name</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $key => $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->reviewer->name }}</td>
                                    <td>{{ $review->comment }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                     <th>id</th>
                                    <th>Reviewer Name</th>
                                    <th>Comment</th>
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
</script>
@endsection