@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Users lists</h1>
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        Add user
    </button>
</div>
@stop

@section('content')
<!-- row -->
<div class="row">


    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Erreur</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-secondary" href="{{ route('users.index') }}">Back</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2" action="{{route('users.store','test')}}" method="post">
                    {{csrf_field()}}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label> Username: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"  data-parsley-class-handler="#lnWrapper" name="name" required="" type="text">
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>Email: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="email" required="" type="email">
                            </div>
                        </div>

                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> Password: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="password" required="" type="password">
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> Confirm password: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="confirm-password" required="" type="password">
                        </div>
                    </div>

                    <div class="row row-sm mg-b-20">
                        <div class="col-lg-6">
                            <label class="form-label">Status user </label>
                            <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label"> User authority</label>
                                <select name="roles_name[]" class="form-control" multiple>
                                    @foreach($roles as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-danger" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

<!-- @section('css')
<style>
    .active { color: green; }
    .inactive { color: red; }
</style>
@endsection
@section('js')
<script>
    function changeStatusColor(select) {
        var selectedOption = select.options[select.selectedIndex];
        if (selectedOption.classList.contains('active')) {
            select.style.color = 'green';
        } else if (selectedOption.classList.contains('inactive')) {
            select.style.color = 'red';
        }
    }
</script>
@endsection -->