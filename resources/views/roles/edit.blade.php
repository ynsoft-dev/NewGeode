@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Edit Permissions</h4>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@stop

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Error</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @method('PATCH')
    @csrf
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="form-group">
                            <p>Permission Name :</p>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" placeholder="Name">
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">Permissions</a>
                                    <ul>
                                        <li>
                                            @foreach($permission as $value)
                                            <label><input type="checkbox" name="permission[]" class="name" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                {{ $value->name }}</label>
                                            <br />
                                            @endforeach
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">Update</button>
                        </div>
                        <!-- /col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
</form>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
