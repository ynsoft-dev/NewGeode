@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Roles lists</h1>
<div class="text-center">
    @can('add_permission')
    <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}" style="width: 170px;">Add role</a>
    @endcan
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

@php
$heads = [
'#',
'name',
['label' => 'Actions', 'no-export' => true, 'width' => 30],
];

@endphp




<x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
    @php
    $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
            <"row" <"col-12" tr> >
                <"row" <"col-sm-12 d-flex justify-content-start" f> >';
                    $config['paging'] = false;
                    $config["lengthMenu"] = [ 10, 50, 100, 500];
                    @endphp
                    <?php $i = 0     ?>
                    @foreach ($roles as $key => $role)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @can('show_permission')
                            <a class="btn btn-xs btn-default text-info mx-1 shadow" href="{{ route('roles.show', $role->id) }}"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            @endcan

                            @can('edit_permission')
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                            @endcan

                            @if ($role->name !== 'owner')

                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                @can('delete_permission')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                @endcan
                            </form>


                            @endif


                        </td>
                    </tr>
                    @endforeach

</x-adminlte-datatable>




@stop