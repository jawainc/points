@extends('layouts.admin')
@section('title', 'Admin Course Sections')
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
            <div class="box">

                {{--Header--}}
                <div class="box-header">
                    <h3 class="box-title">
                        Sections List
                        <a href="{{route('admin.course.sections.add', $course)}}" class="btn btn-xs btn-primary m-l-10">Add New Section</a>
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
                                Section Name
                            </th>

                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($sections as $section)
                            <tr>
                                <td class="td-name">
                                    {{$section->name}}
                                </td>
                                <td class="td-actions text-right">
                                    <a href="{{route('admin.course.sections.edit', $section)}}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.course.sections.destroy', $section)}}">
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
                    {{ $sections->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection