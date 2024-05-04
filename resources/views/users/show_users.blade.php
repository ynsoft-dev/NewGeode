@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Users lists</h1>
<div class="text-center">
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;"> -->
    @can('add_user')
    <a class="btn btn-primary" style="width: 170px;" href="{{ route('users.create') }}">Add user</a>
    @endcan('')
    <!-- </button> -->
</div>
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('delete') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- {{-- Setup data for datatables --}} -->
@php
$heads = [
'#',
'name',
'email',
'Status',
'type',
['label' => 'Actions', 'no-export' => true, 'width' => 30],
];
@endphp

<!-- {{-- Minimal example / fill data using the component slot --}} -->
<x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
    @php
    $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
            <"row" <"col-12" tr> >
                <"row" <"col-sm-12 d-flex justify-content-start" f> >';
                    $config['paging'] = false;
                    $config["lengthMenu"] = [ 10, 50, 100, 500];
                    @endphp
                    <?php $i = 0     ?>
                    @foreach($data as $key => $user)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if ($user->Status == 'active')
                            <span class="label text-success d-flex">
                                <div class="dot-label bg-success ml-1"></div>{{ $user->Status }}
                            </span>
                            @else
                            <span class="label text-danger d-flex">
                                <div class="dot-label bg-danger ml-1"></div>{{ $user->Status }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @can('edit_user')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                            @endcan

                            @can('delete_user')
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow" data-effect="effect-scale" data-user_id="{{ $user->id }}" data-username="{{ $user->name }}" data-toggle="modal" title="Delete" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach

</x-adminlte-datatable>
<!-- delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete User</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('users.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p><br>
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input class="form-control" name="username" id="username" type="text" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
        </div>
        </form>
    </div>
</div>

@stop

@section('js')
<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var username = button.data('username')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #username').val(username);
    })
</script>

@stop