@extends('layouts.admin')
@section('title', 'Admin Students')
@section('page-title')
    <h1>
        <i class="fas fa-user-graduate"></i>
        Students
    </h1>
@endsection
@section('page-css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
    <script src="{{ asset('js/admin/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
@endsection

{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-md-3 col-xs-12">

            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{$student->full_name}}</h3>

                    <p class="text-muted text-center">{{$student->email}}</p>

                    <a href="{{route('admin.students.edit', $student)}}" class="btn btn-primary btn-block"><b>Update</b></a>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- About Student -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Group</strong>

                    <p class="text-muted">{{$student->group->name}}</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Course</h3>
                </div>



                    @include('partials.flash_messages')
                    <form method="post" action="{{route('admin.students.add.course')}}" class="">
                        @csrf
                        <input type="hidden" name="student_id" value="{{$student->id}}">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if ($errors->has('course_id')) has-error @endif">
                                        <label for="course_id">Course <span class="text-danger">*</span></label>


                                        <select name="course_id" class="form-control select-2">
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('course_id')) <span
                                                class="help-block">Course is required</span> @endif
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                                        <label for="course_id">Start Date <span class="text-danger">*</span></label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <input type="text" name="start_date" class="form-control pull-right"
                                                   id="datepicker">
                                        </div>
                                        @if ($errors->has('start_date')) <span
                                                class="help-block">Course start date is required</span> @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info">Add Course</button>
                        </div>

                    </form>
                    {{--</div> --}}


            </div>
            <div class="row">
                @foreach($enrollments as $enrollment)
                    <?php
                    $student_course = $enrollment->course;
                    $complete = $student_course->percentage_complete ($enrollment->student_id, $enrollment->course_id);
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green-gradient">
                            <div class="inner course-box">
                                <h3>{{$student_course->name}}</h3>
                                <h3 class="m-t-15">{{$complete['percent']}}<sup style="font-size: 17px">%</sup></h3>

                                <p>Hours: {{$complete['hours']}} <span class="m-l-15">Points: {{$complete['points']}}</span></p>
                                <p>Start Date: {{($enrollment->start_date != null) ? $enrollment->start_date->format('m/d/Y') : ''}}</p>

                                <div class="remove-enrollment">
                                    <form id="remove-enrollment-{{$enrollment->id}}" method="post" class="deleteRecord inline" action="{{route('admin.students.profile.course.destroy', $enrollment)}}">
                                        @csrf
                                        @method('DELETE')

                                            <i onclick="$('#remove-enrollment-{{$enrollment->id}}').submit();" class="far fa-trash-alt"></i>

                                    </form>
                                </div>

                            </div>
                            <div class="icon">
                                <i class="far fa-chart-bar"></i>
                            </div>
                            <a href="{{route('admin.students.profile.course', ['student' => $student, 'course' => $student_course])}}"
                               class="small-box-footer">
                                More <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>


@endsection

@section('inline-page-scripts')
    <script>
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });
    </script>
@endsection