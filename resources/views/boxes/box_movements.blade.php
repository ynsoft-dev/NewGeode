@extends('adminlte::page')

@section('title', 'Box Movements')

@section('content_header')
<h1>Box Movements</h1>
@stop

@section('content')
<x-adminlte-datatable id="table1" :heads="['#', 'Request Number', 'Transmission Date', 'Return Date', 'Real Return Date', 'Status']" striped hoverable with-buttons>
    @foreach($movements as $movement)
        <tr>
            <td>{{ $movement->id }}</td>
            <td>{{ $movement->request_number }}</td>
            <td>{{ $movement->transmission_date }}</td>
            <td>{{ $movement->return_date }}</td>
            <td>{{ $movement->real_return_date }}</td>
            <td>{{ $movement->status }}</td>
        </tr>
    @endforeach
</x-adminlte-datatable>
@stop
