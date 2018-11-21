@extends('layouts.admin')
@section('title', 'Admin Settings')
@section('page-title')
    <h1>
        <i class="fas fa-cogs"></i>
        Settings
    </h1>
@endsection
@section('page-css')
    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet">
    <style>
        .td-name{
            width: 300px;
        }
        .td-actions{
            width: 200px;
        }
        textarea, input[type='text'] {
            width: 100%;
        }
    </style>
@endsection
@section('page-scripts')
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
@endsection

{{--Page Contents--}}
@section('content')

    {{--Setting Form--}}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Setting</h3>
                </div>

                <form role="form" method="post" action="{{route('admin.settings.store')}}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="exampleInputEmail1">Setting Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @if ($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
                        </div>

                        <div class="form-group">
                            <label>Select Type</label>
                            <select name="type" class="form-control">
                                <option value="text_field" {{(old('type') == 'text_field')? 'selected':''}}>Text Field</option>
                                <option value="text_area" {{(old('type') == 'text_area')? 'selected':''}}>Text Area</option>
                                <option value="checkbox" {{(old('type') == 'checkbox')? 'selected':''}}>Checkbox</option>
                            </select>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                {{--Header--}}
                <div class="box-header">
                    <h3 class="box-title">
                        Settings
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

                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($settings as $setting)
                            <tr>
                                <td class="td-name">
                                    {{$setting->name}}
                                </td>
                                <td>
                                    @if($setting->type == 'checkbox')
                                        <label>
                                            <input type="checkbox" id="value_{{$setting->id}}" value="1" class="minimal" {{($setting->value == '1')? 'checked': ''}} >
                                        </label>
                                    @elseif($setting->type == 'text_field')
                                        <input type="text" id="value_{{$setting->id}}" value="{{$setting->value}}">
                                    @elseif($setting->type == 'text_area')
                                        <textarea id="value_{{$setting->id}}" rows="5" cols="10">{{$setting->value}}</textarea>
                                    @endif
                                </td>

                                <td class="td-actions text-right">
                                    <form method="post" class="inline" onsubmit="return editSetting({{$setting->id}})" action="{{route('admin.settings.update', $setting)}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="form_value_{{$setting->id}}" value="" name="value">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>

                                    <form method="post" class="deleteRecord inline" action="{{route('admin.settings.destroy', $setting)}}">
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


            </div>

        </div>
    </div>



@endsection

@section('inline-page-scripts')
    <script>
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        })

        function editSetting(id) {
            if ($('#value_'+id).is(':checkbox')) {
                $('#form_value_'+id).val($('#value_'+id). prop("checked")? '1': '0');
            } else {
                $('#form_value_'+id).val($('#value_'+id).val());
            }

            return true
        }
    </script>
@endsection