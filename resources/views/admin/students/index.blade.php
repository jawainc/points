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
        <div class="col-xs-12">
            <div class="box">

                {{--Header--}}
                <div class="box-header">
                    <h3 class="box-title">
                        Students List
                        <a href="{{URL::route('admin.students.create')}}" class="btn btn-xs btn-primary m-l-10">Add New</a>
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
                                Name
                            </th>

                            <th>
                                Email
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($students as $student)
                            <tr>
                                <td class="td-name">
                                    {{$student->full_name}}
                                </td>
                                <td>
                                    {{$student->email}}
                                </td>

                                <td class="td-actions text-right">
                                    <a href="{{route('admin.students.show', $student)}}" title="student profile"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    <a href="{{route('admin.students.edit', $student)}}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.students.destroy', $student)}}">
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
                    {{ $students->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection