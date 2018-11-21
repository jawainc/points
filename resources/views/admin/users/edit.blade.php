@extends('layouts.admin')
@section('title', 'Admin Users')
@section('page-title')
    <h1>
        <i class="fas fa-users-cog"></i>
        Users
    </h1>
@endsection
@section('page-css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
    <script src="{{ asset('js/admin/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

{{--Page Contents--}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                {{--Header--}}
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Users
                        <a href="{{route('admin.users.index')}}" class="btn btn-xs btn-primary m-l-10">Users</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.users.update', compact('user'))}}">
                    @csrf
                    @method('PUT')
                    <div class="box-body m-t-20">
                         @include('partials.flash_messages')
                         @include('admin.users.forms.user_form')
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection