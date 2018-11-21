@extends('layouts.admin')
@section('title', 'Admin Student Groups')
@section('page-title')
    <h1>
        <i class="fas fa-user-graduate"></i>
        Student Groups
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
                        Groups
                        <a href="{{route('admin.students.groups.new')}}" class="btn btn-xs btn-primary m-l-10">Add New</a>
                    </h3>
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

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($student_groups as $group)
                            <tr>
                                <td class="td-name">
                                    {{$group->name}}
                                </td>
                                <td class="td-actions text-right">
                                    <a href="{{route('admin.students.groups.edit', ['id' => $group->id])}}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.students.groups.destroy')}}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{$group->id}}">
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
                    {{ $student_groups->links() }}
                </div>

            </div>
        </div>

    </div>

@endsection