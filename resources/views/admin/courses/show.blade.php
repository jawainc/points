@extends('layouts.admin')
@section('title', 'Admin Students')
@section('page-title')
    <h1>
        <i class="fas fa-user-graduate"></i>
        Students
    </h1>
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
                    <a href="#" class="btn btn-success btn-block"><b>Update Courses</b></a>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- About Student -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Category</strong>

                    <p class="text-muted">{{$student->category->name}}</p>

                    <hr>

                    <strong>Group</strong>

                    <p class="text-muted">{{$student->group->name}}</p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>


        <div class="col-md-9 col-xs-12">
            <div class="row">
                @if ($student->courses_count > 0)
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green-gradient">
                            <div class="inner">
                                <h3>Test Course</h3>
                                <h3 class="m-t-15">53<sup style="font-size: 17px">%</sup></h3>

                                <p>Hours: 53 <span class="m-l-15">Points: 150</span></p>

                            </div>
                            <div class="icon">
                                <i class="far fa-chart-bar"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                @endif
            </div>
        </div>

    </div>


@endsection

