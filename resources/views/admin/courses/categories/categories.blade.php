@extends('layouts.admin')
@section('title', 'Admin Course Categories')
@section('page-title')
    <h1>
        <i class="fas fa-chalkboard-teacher"></i>
        Course Categories
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
                        Categories
                        <a href="{{route('admin.categories.course.create')}}" class="btn btn-xs btn-primary m-l-10">Add New</a>
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

                        @foreach($categories as $cat)
                            <tr>
                                <td class="td-name">
                                    {{$cat->name}}
                                </td>
                                <td class="td-actions text-right">
                                    <a href="{{route('admin.categories.course.edit', $cat)}}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.categories.course.destroy', $cat)}}">
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
                    {{ $categories->links() }}
                </div>

            </div>
        </div>

    </div>

@endsection