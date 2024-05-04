@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Add Permissions</h4>
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

<form method="POST" action="{{ route('roles.store') }}">
    @csrf
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                                <p>Permission Name :</p>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">Permission :</a>
                                    <ul>
                                        @foreach($permission as $value)
                                        <li>
                                            <label style="font-size: 16px;"><input type="checkbox" name="permission[]" class="name" value="{{ $value->id }}">
                                                {{ $value->name }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /col -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-danger">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
</form>

@stop