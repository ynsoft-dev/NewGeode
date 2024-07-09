@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

<h1>List of pending Destruction boxes</h1>

@stop

@section('content')



<style>
    /* .modal-dialog {
        max-width: 70%;
    } */
    .fa-custom-size {
        font-size: 17px;
    }
</style>

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
$config = ['format' => 'YYYY'];
@endphp


<!-- {{-- Setup data for datatables --}} -->
@php
$heads = [
'#',
'Box name',
'Direction',
'Department',
'content',
'Extreme date',
'Destruction',
'Status',

['label' => 'Location', 'no-export' => true, 'width' => 30 ],
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
                    @foreach($boxes as $box)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$box->ref}}</td>
                        <td>{{$box->archiveRequest->direction->name}}</td>
                        <td>{{$box->archiveRequest->department->name}}</td>
                        <td>{!! nl2br(e($box->content)) !!}</td>
                        <td>{{$box->extreme_date}}</td>
                        <td>{{$box->destruction_date}}</td>
                        <td>
                            @if($box->status === 'Available')
                            <span class="badge badge-success">{{ ucfirst($box->status) }}</span>
                            @elseif($box->status === 'Not available')
                            <span class="badge badge-danger">{{ ucfirst($box->status) }}</span>
                            @endif
                        </td>

                        <td>{{$box->location}}</td>
                    
                        <td>
                            <form action="{{ route('boxes.delete', $box->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-adminlte-button type="submit" label="Destroy" class="btn-sm bg-gradient-danger" title="Destroy"/>
                            </form>
                        </td>
                    </tr>
                    @endforeach
</x-adminlte-datatable>
@stop