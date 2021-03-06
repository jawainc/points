@extends('layouts.admin')
@section('title', 'Admin Students')
@section('page-title')
    <h1>
        <i class="fas fa-chalkboard-teacher"></i>
        Courses
    </h1>
@endsection
@section('page-css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
    <script src="{{ asset('js/admin/select2.full.min.js') }}" type="text/javascript"></script>
@endsection


{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                {{--Header--}}
                <div class="box-header with-border">
                    <h3 class="box-title">
                        New Course
                        <a href="{{route('admin.courses.index')}}" class="btn btn-xs btn-primary m-l-10">Courses</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.courses.store')}}">
                    @csrf
                    <div class="box-body m-t-20">

                                @include('partials.flash_messages')
                                @include('admin.courses.forms.course_form')

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection