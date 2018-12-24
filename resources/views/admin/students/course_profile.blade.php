@extends('layouts.admin')
@section('title', 'Admin Students')
@section('page-title')
    <h1>
        <i class="fas fa-user-graduate"></i>
        Students
    </h1>
@endsection
@section('page-scripts')
    <script src="{{ asset('js/admin/Chart.min.js') }}" type="text/javascript"></script>
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
                    <a href="{{route('admin.students.show', $student)}}"
                       class="btn btn-success btn-block"><b>Courses</b></a>
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header ">
                            <h3 class="box-title">Course: {{$course->name}}</h3>
                        </div>

                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart" style="height:250px"></canvas>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fas fa-percentage"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Complete</span>
                            <span class="info-box-number">{{$points_calculation['percent']}}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{$points_calculation['percent']}}%"></div>
                            </div>
                            <span class="progress-description">
                                            {{$points_calculation['percent']}}% complete
                                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fas fa-hourglass-half"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Hours</span>
                            <span class="info-box-number">{{$points_calculation['hours']}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fas fa-chart-area"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Points</span>
                            <span class="info-box-number">{{$points_calculation['points']}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Course Sections</h3>
                        </div>

                        <div class="box-body">
                            @include('partials.flash_messages')
                            @include('partials.error_messages')
                            <table class="table ">
                                <tr>
                                    <th>Section</th>
                                    <th class="text-center">Hours</th>
                                    <th class="text-center">Minutes</th>
                                    <th class="text-center">Points</th>
                                    <th></th>
                                </tr>
                                @foreach($points as $point)
                                    <tr>
                                        <td>{{$point->course_section->name}}</td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->hours}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_hours_{{$point->id}}" type="text"
                                                       value="{{$point->hours}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->minutes}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_minutes_{{$point->id}}" type="text"
                                                       value="{{$point->minutes}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->points}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_points_{{$point->id}}" type="text"
                                                       value="{{$point->points}}">
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-xs section_value{{$point->id}}"
                                                    onclick="showEditForm({{$point->id}})"><i
                                                        class="fas fa-pencil-alt"></i></button>
                                            <button style="display: none;"
                                                    class="btn btn-success btn-xs section_edit{{$point->id}}"
                                                    onclick="editPoint('{{$point->id}}')"><i class="fas fa-save"></i>
                                            </button>
                                            <form method="post" class="deleteRecord inline"
                                                  action="{{route('admin.students.profile.point', $point)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <form id="point_edit_form" method="post" action="{{route('admin.students.profile.point.update')}}">
            @csrf
            @method('PUT')
            <input id="point_edit_id" value="" name="id" type="hidden">
            <input id="point_edit_hours" value="" name="hours" type="hidden">
            <input id="point_edit_minutes" value="" name="minutes" type="hidden">
            <input id="point_edit_points" value="" name="points" type="hidden">
        </form>

        @endsection

@section('inline-page-scripts')
            <script>

                var showEdit = 0;

                function showEditForm(id) {
                    if (showEdit == 0) {
                        showEdit = id;
                        $('.section_edit' + id).show();
                        $('.section_value' + id).hide();
                    } else {
                        $('.section_edit' + id).show();
                        $('.section_value' + id).hide();

                        $('.section_edit' + showEdit).hide();
                        $('.section_value' + showEdit).show();

                        showEdit = id;
                    }
                }

                function editPoint(id) {
                    $('#point_edit_id').val(id);
                    $('#point_edit_hours').val($('#section_edit_hours_' + id).val());
                    $('#point_edit_minutes').val($('#section_edit_minutes_' + id).val());
                    $('#point_edit_points').val($('#section_edit_points_' + id).val());
                    $('#point_edit_form').submit();
                }

                var chartLabels = [];
                var points = [];
                var hours = [];
                var ph = [];

                @foreach($points as $point)
                chartLabels.push('{{$point->created_at->format('m/d/y')}}');
                points.push({{$point->points}});
                hours.push({{$point->total_hours}});
                ph.push({{($point->total_hours > 0 )? number_format($point->points/$point->total_hours, 2): 0}});
                        @endforeach

                var lineChartData = {
                        labels: chartLabels,
                        datasets: [
                            {
                                label: 'Points',
                                borderColor: '#00BCD4',
                                backgroundColor: '#00BCD4',
                                fill: false,
                                data: points,
                                yAxisID: 'y-axis-1',
                            },
                            {
                                label: 'Hours',
                                borderColor: '#000000',
                                backgroundColor: '#000000',
                                fill: false,
                                data: hours,
                                yAxisID: 'y-axis-2',
                            },
                            {
                                label: 'Points/Hour',
                                borderColor: '#8BC34A',
                                backgroundColor: '#8BC34A',
                                fill: false,
                                data: ph,
                                yAxisID: 'y-axis-3'
                            }]
                    };

                window.onload = function () {
                    var ctx = document.getElementById('lineChart').getContext('2d');
                    window.myLine = Chart.Line(ctx, {
                        data: lineChartData,
                        options: {
                            responsive: true,
                            hoverMode: 'index',
                            stacked: false,
                            title: {
                                display: false,
                                text: ''
                            },
                            scales: {
                                yAxes: [
                                    {
                                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                                        display: true,
                                        position: 'left',
                                        id: 'y-axis-1',
                                    },
                                    {
                                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                                        display: true,
                                        position: 'left',
                                        id: 'y-axis-2',
                                    },
                                    {
                                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                                        display: true,
                                        position: 'right',
                                        id: 'y-axis-3',

                                        // grid line settings
                                        gridLines: {
                                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                                        },
                                    }],
                            }
                        }
                    });
                };

            </script>




@endsection