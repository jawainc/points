<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('first_name')) has-error @endif">
            <label class="bmd-label-floating">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" value="{{old('first_name', $student->first_name)}}">
            @if ($errors->has('first_name')) <span class="help-block">{{ $errors->first('first_name') }}</span> @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('last_name')) has-error @endif">
            <label class="bmd-label-floating">Last Name <span class="required">*</span></label>
            <input type="text" class="form-control" name="last_name" value="{{old('last_name', $student->last_name)}}">
            @if ($errors->has('last_name')) <span class="help-block">{{ $errors->first('last_name') }}</span> @endif
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('email')) has-error @endif">
            <label class="bmd-label-floating">Email <span class="required">*</span></label>
            <input type="email" class="form-control" name="email" value="{{old('email', $student->email)}}">
            @if ($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('student_category_id')) has-error @endif">
            <label >Select Student Category <span class="text-danger">*</span></label>

            <select name="student_category_id" class="form-control select-2">
                <option value="">Select Category</option>
                @foreach($student_categories as $category)
                    <option value="{{$category->id}}"
                            {{(old('student_category_id', $student->student_category_id) == $category->id)? 'selected':''}}
                    >{{$category->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('student_category_id')) <span class="help-block">Student category is required</span> @endif

        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('student_group_id')) has-error @endif">
            <label >Select Student Group <span class="text-danger">*</span></label>

            <select name="student_group_id" class="form-control select-2">
                <option value="">Select Group</option>
                @foreach($student_groups as $group)
                    <option value="{{$group->id}}"
                            {{(old('student_group_id', $student->student_group_id) == $group->id)? 'selected':''}}
                    >{{$group->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('student_group_id')) <span class="help-block">Student group is required</span> @endif


        </div>
    </div>
</div>








