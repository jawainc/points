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
                                    <th >Section</th>
                                    <th class="text-center">Hours</th>
                                    <th class="text-center">Minutes</th>
                                    <th class="text-center">Points</th>
                                    <th ></th>
                                </tr>
                                @foreach($points as $point)
                                    <tr>
                                        <td>{{$point->course_section->name}}</td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->hours}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_hours_{{$point->id}}" type="text" value="{{$point->hours}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->minutes}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_minutes_{{$point->id}}" type="text" value="{{$point->minutes}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="section_value{{$point->id}}">{{$point->points}}</div>
                                            <div class="section_edit{{$point->id}}" style="display: none;">
                                                <input id="section_edit_points_{{$point->id}}" type="text" value="{{$point->points}}">
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-xs section_value{{$point->id}}" onclick="showEditForm({{$point->id}})"><i class="fas fa-pencil-alt"></i></button>
                                            <button style="display: none;" class="btn btn-success btn-xs section_edit{{$point->id}}" onclick="editPoint('{{$point->id}}')"><i class="fas fa-save"></i></button>
                                            <form method="post" class="deleteRecord inline" action="{{route('admin.students.profile.point', $point)}}">
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
                        $('.section_edit'+id).show();
                        $('.section_value'+id).hide();
                    } else {
                        $('.section_edit'+id).show();
                        $('.section_value'+id).hide();

                        $('.section_edit'+showEdit).hide();
                        $('.section_value'+showEdit).show();

                        showEdit = id;
                    }
                }

                function editPoint(id) {
                    $('#point_edit_id').val(id);
                    $('#point_edit_hours').val($('#section_edit_hours_'+id).val());
                    $('#point_edit_minutes').val($('#section_edit_minutes_'+id).val());
                    $('#point_edit_points').val($('#section_edit_points_'+id).val());
                    $('#point_edit_form').submit();
                }

                var chartLabels = [];
                var data = [];

                @foreach($points as $point)
                chartLabels.push({{$point->hours}});
                data.push({{$point->points}});
                        @endforeach

                var chartData = {
                        labels: chartLabels,
                        datasets: [
                            {
                                label: 'Points',
                                fillColor: 'rgba(60,141,188,0.9)',
                                strokeColor: 'rgba(60,141,188,0.8)',
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: data
                            }
                        ]
                    };

                var chartOptions = {
                    //Boolean - If we should show the scale at all
                    showScale: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: false,
                    //String - Colour of the grid lines
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - Whether the line is curved between points
                    bezierCurve: true,
                    //Number - Tension of the bezier curve between points
                    bezierCurveTension: 0.3,
                    //Boolean - Whether to show a dot for each point
                    pointDot: false,
                    //Number - Radius of each point dot in pixels
                    pointDotRadius: 4,
                    //Number - Pixel width of point dot stroke
                    pointDotStrokeWidth: 1,
                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                    pointHitDetectionRadius: 20,
                    //Boolean - Whether to show a stroke for datasets
                    datasetStroke: true,
                    //Number - Pixel width of dataset stroke
                    datasetStrokeWidth: 2,
                    //Boolean - Whether to fill the dataset with a color
                    datasetFill: true,
                    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio: true,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive: true
                };

                //-------------
                //- LINE CHART -
                //--------------
                var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
                var lineChart = new Chart(lineChartCanvas);
                var lineChartOptions = chartOptions;
                lineChartOptions.datasetFill = false;
                lineChart.Line(chartData, chartOptions);
            </script>
@endsection