{{--Save--}}
@if (session('save'))
    <div class="alert alert-success alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        {{ session('save') }}
    </div>
@endif

{{--Update--}}
@if (session('update'))
    <div class="alert alert-info alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> Update!</h4>
        {{ session('update') }}
    </div>
@endif

{{--Info--}}
@if (session('info'))
    <div class="alert alert-info alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('info') }}
    </div>
@endif

{{--Warning--}}
@if (session('warning'))
    <div class="alert alert-warning alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('warning') }}
    </div>
@endif

{{--Warning--}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('error') }}
    </div>
@endif

{{--Errors--}}
{{--
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{ $error }}
        </div>
    @endforeach
@endif--}}
