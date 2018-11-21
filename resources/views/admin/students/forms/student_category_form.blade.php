<div class="form-group @if ($errors->has('name')) has-error @endif">
    <label for="name" class="bmd-label-floating">Category Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name', $student_category->name)}}">

    @if ($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
</div>
