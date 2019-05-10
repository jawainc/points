<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('name')) has-error @endif">
            <label class="bmd-label-floating">Course Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{old('name', $course->name)}}">
            @if ($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('course_category_id')) has-error @endif">
            <label >Select Course Category <span class="text-danger">*</span></label>

            <select name="course_category_id" class="form-control select-2">
                <option value="">Select Category</option>
                @foreach($course_categories as $category)
                    <option value="{{$category->id}}"
                            {{(old('course_category_id', $course->course_category_id) == $category->id)? 'selected':''}}
                    >{{$category->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('course_category_id')) <span class="help-block">Course category is required</span> @endif

        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label class="bmd-label-floating">Course Quota</label>
            <input type="text" class="form-control" name="quota" value="{{old('quota', $course->quota)}}">
        </div>
    </div>

</div>









