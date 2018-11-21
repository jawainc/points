@extends('layouts.admin')
@section('title', 'Admin Students')
@section('page-title')
    <h1>
        <i class="fas fa-chalkboard-teacher"></i>
        Courses
    </h1>
@endsection

{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                {{--Header--}}
                <div class="box-header">
                    <h3 class="box-title">
                        Courses List
                        <a href="{{route('admin.courses.create')}}" class="btn btn-xs btn-primary m-l-10">Add New</a>
                    </h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--Table--}}

                <div class="box-body table-responsive ">
                    @include('partials.flash_messages')
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                Course Name
                            </th>

                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($courses as $course)
                            <tr>
                                <td class="td-name">
                                    {{$course->name}}
                                </td>
                                <td class="td-actions text-right">
                                    <a href="{{route('admin.course.sections', $course)}}"
                                       class="btn btn-default btn-sm">
                                        Sections
                                    </a>
                                    <a href="{{route('admin.courses.edit', $course)}}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.courses.destroy', $course)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{--Pagination--}}
                <div class="box-footer">
                    {{ $courses->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection