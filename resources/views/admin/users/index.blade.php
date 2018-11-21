@extends('layouts.admin')
@section('title', 'Admin Users')
@section('page-title')
    <h1>
        <i class="fas fa-users-cog"></i>
        Users
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
                        Users List
                        <a href="{{URL::route('admin.users.create')}}" class="btn btn-xs btn-primary m-l-10">Add New</a>
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
                                Role
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td class="td-name">
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>

                                <td>
                                    @if ($user->role()->exists())
                                        {{$user->role->name}}
                                    @endif
                                </td>

                                <td class="td-actions text-right">
                                    <a href="{{route('admin.users.edit', $user)}}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="deleteRecord inline" action="{{route('admin.users.destroy', $user)}}">
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
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection