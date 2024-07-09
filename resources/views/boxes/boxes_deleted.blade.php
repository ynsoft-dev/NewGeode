@extends('adminlte::page')

@section('title', 'Deleted Boxes')

@section('content_header')
    <h1>List of Deleted Boxes</h1>
@stop

@section('content')
    <style>
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
            'Box name',
            'Direction',
            'Department',
            'Content',
            'Extreme date',
            'Destruction date',
            'Deleted At',
        ];
    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
        @php
            $i = 0;
        @endphp
        @foreach($boxes as $box)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $box->ref }}</td>
                <td>{{ $box->archiveRequest->direction->name }}</td>
                <td>{{ $box->archiveRequest->department->name }}</td>
                <td>{!! nl2br(e($box->content)) !!}</td>
                <td>{{ $box->extreme_date }}</td>
                <td>{{ $box->destruction_date }}</td>
                </td>
                <td>{{ $box->location }}</td>
                <td>{{ $box->deleted_at }}</td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop
