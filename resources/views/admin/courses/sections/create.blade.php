@extends('layouts.admin')
@section('title', 'Course Sections')
@section('page-title')
    <h1>
        <i class="fas fa-chalkboard-teacher"></i>
        Course: {{$course->name}} Sections
    </h1>
@endsection

{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                {{--Header--}}
                <div class="box-header with-border">
                    <h3 class="box-title">
                        New Section
                        <a href="{{route('admin.course.sections', $course)}}" class="btn btn-xs btn-primary m-l-10">Sections</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.course.sections.create', $course)}}">
                    @csrf
                    <div class="box-body m-t-20">

                                @include('partials.flash_messages')
                                @include('admin.courses.forms.section_form')

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection