@extends('layouts.admin')
@section('title', 'Admin Students Categories')
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
                        Add New
                        <a href="{{route('admin.students.groups')}}" class="btn btn-xs btn-primary m-l-10">Groups</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.students.groups.add')}}">
                    @csrf
                    <div class="box-body m-t-20">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                @include('partials.flash_messages')
                                @include('admin.students.forms.student_group_form')
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection