@extends('layouts.admin')
@section('title', 'Admin Graphs')
@section('page-title')
    <h1>
        <i class="fas fa-chart-line"></i>
        Graphs
    </h1>
@endsection
@section('page-css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
    <script src="{{ asset('js/admin/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-xs-12">

            <!-- Graph Search -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>
                </div>

                @include('partials.flash_messages')
                <form method="post" action="{{route('admin.graphs.search')}}" class="">
                    @csrf
                    <div class="box-body">
                        <div class="row">

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label >Select Student</label>

                                    <select name="student_id" class="form-control select-2">
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                            <option value="{{$student->id}}"
                                                    {{(old('student_id') == $student->id)? 'selected':''}}
                                            >{{$student->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label >Select Course</label>

                                    <select name="course_id" class="form-control select-2">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}"
                                                    {{(old('course_id') == $course->id)? 'selected':''}}
                                            >{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label >Select Section</label>

                                    <select name="section_id" class="form-control select-2">
                                        <option value="">Select Section</option>
                                        @foreach($course_sections as $section)
                                            <option value="{{$section->id}}"
                                                    {{(old('section_id') == $section->id)? 'selected':''}}
                                            >{{$section->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label >Select Student Group</label>

                                    <select name="group_id" class="form-control select-2">
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}"
                                                    {{(old('group_id') == $group->id)? 'selected':''}}
                                            >{{$group->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-md-3">
                                <div class="form-group ">
                                    <label >From Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <input type="text" name="from_date" value="{{old('from_date')}}" class="form-control pull-right datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group ">
                                    <label >To Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <input type="text" name="to_date" value="{{old('to_date')}}"  class="form-control pull-right datepicker">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-info">Search</button>
                        <button type="reset" class="btn" onclick="resetForm()">Reset</button>
                    </div>

                </form>
                {{--</div> --}}


            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <div class="box box-info">
                <div class="box-body">
                    <div class="chart">
                        <canvas id="lineChart" style="height:350px"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('inline-page-scripts')
    <script>
        var chartLabels = [];
        var points = [];
        var hours = [];
        var ph = [];

        @foreach($points as $point)
            var pts = parseFloat('{{$point->total_points}}');
            var hrs = timeConvert('{{$point->t_hours}}', '{{$point->total_minutes}}');
            chartLabels.push('{{Carbon\Carbon::parse($point->date)->format('m/d/y')}}');
            points.push(pts);
            hours.push(hrs);
            ph.push((pts > 0 ) ? (pts/hrs).toFixed(2): 0);
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

        /**
         * convert hrs amd minutes to total hours
         * @param hrs
         * @param mins
         * @returns {number}
         */
        function timeConvert (hrs, mins){
            let minutes = parseInt(mins) % 60;
            let hours = (parseInt(mins) - minutes) / 60;
            let totalHours = parseInt(hrs) + hours;
            return parseFloat(totalHours +"."+ minutes);
        }

        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            orientation: 'bottom'
        });
        
        function resetForm() {
            $(".select-2").val("").trigger('change');;
        }

    </script>




@endsection