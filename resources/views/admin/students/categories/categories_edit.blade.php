@extends('layouts.admin')
@section('title', 'Admin Students Categories')
@section('page-title')
    <h1>
        <i class="fas fa-user-graduate"></i>
        Student Categories
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
                        Edit Category
                        <a href="{{route('admin.students.categories')}}" class="btn btn-xs btn-primary m-l-10">Categories</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.students.categories.add')}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$student_category->id}}">
                    <div class="box-body m-t-20">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                @include('partials.flash_messages')
                                @include('admin.students.forms.student_category_form')
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
