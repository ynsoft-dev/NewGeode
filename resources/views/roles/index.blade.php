@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Roles lists</h1>
<div class="text-center">
    <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}" style="width: 170px;">Add role</a>
</div>
@stop



@section('content')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)



@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('delete'))
    <div class="alert alert-danger">
        {{ session('delete') }}
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
                            <a class="btn btn-success btn-sm" href="{{ route('roles.show', $role->id) }}">Show</a>



                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">Update</a>


                            @if ($role->name !== 'owner')

                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>


                            @endif


                        </td>
                    </tr>
                    @endforeach

</x-adminlte-datatable>




@stop