@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Users lists</h1>
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        Edit user
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

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label> Username: <span class="tx-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>Email : <span class="tx-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>

                            </div>
                        </div>

                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> Password: <span class="tx-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>

                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> Confirm Password: <span class="tx-danger">*</span></label>
                            <input type="password" name="confirm-password" class="form-control" required>

                        </div>
                    </div>

                    <div class="row row-sm mg-b-20">
                        <div class="col-lg-6">
                            <label class="form-label">User Status </label>
                            <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="{{ $user->Status}}">{{ $user->Status}}</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Type User</strong>
                                <select name="roles[]" class="form-control" multiple>
                                    @foreach($roles as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, $userRole) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-danger" type="submit">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@stop