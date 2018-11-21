<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('name')) has-error @endif">
            <label class="bmd-label-floating">Section Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{old('name', $section->name)}}">
            @if ($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('details')) has-error @endif">
            <label >Section Details</label>

            <textarea name="details" rows="5" class="form-control">{{old('details', $section->details)}}</textarea>
            @if ($errors->has('details')) <span class="help-block">{{ $errors->first('details') }}</span> @endif

        </div>
    </div>

</div>









