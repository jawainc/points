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
                        Edit Category
                        <a href="{{route('admin.categories.course.index')}}" class="btn btn-xs btn-primary m-l-10">Categories</a>
                    </h3>
                </div>
                {{--Form--}}
                <form role="form" method="post" action="{{route('admin.categories.course.update', $courseCategory)}}">
                    <input type="hidden" value="{{$courseCategory->id}}" name="id">
                    @csrf
                    @method('PUT')
                    <div class="box-body m-t-20">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                @include('partials.flash_messages')
                                @include('admin.courses.forms.category_form')
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
