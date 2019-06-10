<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.4.8/collection/icon/icon.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skin-blue.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        label.error {
            color: red !important;
      }
        .error {
            color: red !important;
            border-color: red !important;
        }
    </style>
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('includes/header')
        @include('includes/main-sidebar')
        @yield('content')
        @include('includes/footer')
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    @if($errors->any())
    <script type="text/javascript">
        $(document).ready(function() {
            var errors = <?php echo json_encode($errors->getMessages()); ?>;
            var $validator = $(".form_validation").validate();
            $validator.showErrors(errors);
        });
    </script>
    @endif

    @if(Session::has('success'))
        <script type="text/javascript">
            toastr.success("{!! Session::get('success') !!}", {timeOut: 5000});
        </script>
        {{Session::forget('success')}}
    @endif

    @if(Session::has('error'))
        <script type="text/javascript">
            toastr.error("{!! Session::get('error') !!}", {timeOut: 5000});
        </script>
        {{Session::forget('error')}}
    @endif

    @if(Session::has('info'))
        <script type="text/javascript">
            toastr.info("{!! Session::get('info') !!}", {timeOut: 5000});
        </script>
        {{Session::forget('info')}}
    @endif

    @if(Session::has('warning'))
        <script type="text/javascript">
            toastr.warning("{!! Session::get('warning') !!}", {timeOut: 5000});
        </script>
        {{Session::forget('warning')}}
    @endif

    @yield('scripts')
</body>
</html>
