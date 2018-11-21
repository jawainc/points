<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name', 'Students Point System') }} - @yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Material Dashboard CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!--Css injection from view-->
    @section('page-css')
    @show

    <link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_spacing.css') }}" rel="stylesheet">

</head>
<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
        {{--Nav Bar--}}
        @include('partials.admin.navbar')
        {{--Side Bar--}}
        @include('partials.admin.sidebar')
        {{--Content Wrapper. Contains page content--}}
            <div class="content-wrapper">
                {{--Content Header (Page header)--}}
                <section class="content-header">
                    @section('page-title')
                    @show
                    <ol class="breadcrumb">
                        @section('breadcrumb')
                        @show
                    </ol>
                </section>

                {{--Main content--}}
                <section class="content">

                    @yield('content')

                </section>
            </div>
    </div>

{{--Footer--}}
@include('partials.admin.footer')


<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="{{ asset('js/admin/jquery.min.js') }}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script type="text/javascript" src="{{ asset('js/admin/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script type="text/javascript" src="{{ asset('js/admin/fastclick.js') }}"></script>

<!--Script injection from view-->
@section('page-scripts')
@show

<!-- Core JavaScript -->
<script type="text/javascript" src="{{ asset('js/admin/adminlte.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/custom.js') }}"></script>

@section('inline-page-scripts')
@show

</body>
</html>