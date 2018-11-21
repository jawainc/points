<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group ">
            <label>Select Student</label>

            <input type="hidden" name="student_id" id="student_id" value="{{old('student_id', $user->student_id)}}">
            <select name="student" class="form-control select-2" onchange="studentSelected(this.value)">
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{$student->id}},{{$student->full_name}},{{$student->email}}"
                            {{(old('student', $user->student_id) == $student->id)? 'selected':''}}
                    >{{$student->full_name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('role_id')) has-error @endif">
            <label>Select Role <span class="text-danger">*</span></label>

            <select name="role_id" class="form-control select-2">
                <option value="">Select Role</option>

                @foreach($roles as $role)
                    <option value="{{$role->id}}"
                            {{(old('role_id', $user->role_id) == $role->id)? 'selected':''}}
                    >{{$role->name}}</option>
                @endforeach

            </select>
            @if ($errors->has('role_id')) <span class="help-block">Role is required</span> @endif


        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('name')) has-error @endif">
            <label class="bmd-label-floating">Name <span class="text-danger">*</span></label>
            <input type="text" id="name" class="form-control" name="name" value="{{old('name', $user->name)}}">
            @if ($errors->has('name')) <span class="help-block">{{ $errors->first('name') }}</span> @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('email')) has-error @endif">
            <label class="bmd-label-floating">Email <span class="required">*</span></label>
            <input type="email" id="email" class="form-control" name="email" value="{{old('email', $user->email)}}">
            @if ($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('password')) has-error @endif">
            <label class="bmd-label-floating">Password <span class="required">*</span></label>
            <input type="password" class="form-control" name="password" value="">
            @if ($errors->has('password')) <span class="help-block">{{ $errors->first('password') }}</span> @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group @if ($errors->has('confirm_password')) has-error @endif">
            <label class="bmd-label-floating">Confirm Password <span class="required">*</span></label>
            <input type="password" class="form-control" name="confirm_password" value="">
            @if ($errors->has('confirm_password')) <span class="help-block">{{ $errors->first('confirm_password') }}</span> @endif
        </div>
    </div>

</div>

@section('inline-page-scripts')
    <script>
        function studentSelected(value) {
            console.log(value);
            if (value !== "") {
                var values = value.split(',');
                $("#student_id").val(values[0]);
                $("#name").val(values[1]);
                $("#email").val(values[2]);
            } else {
                $("#student_id").val('');
                $("#name").val('');
                $("#email").val('');
            }

        }
    </script>
@endsection






