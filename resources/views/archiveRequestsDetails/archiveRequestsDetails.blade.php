@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<x-adminlte-card title="Info Request" theme="info" icon="fas fa-lg fa-bell" collapsible>
    <!-- An info theme card with all the tool buttons... -->

    <p name="name_request"><b>Name of the request : </b> {{ $demands->name }}</p>
    <p name="name_user"><b>User : </b>
        @foreach($details as $detail)
        {{ $detail->user}}
        @endforeach
    </p>
    <p name="details_request"><b>Details of the request : </b> {{ $demands->details_request }}</p>
    <p name="date_request"><b>Request date : </b> {{ $demands->request_date }}</p>
    <p name="Direction"><b>Direction : </b> {{ $demands->direction->name }}</p>
    <p name="depart"><b>Department : </b> {{ $demands->department->name}}</p>

</x-adminlte-card>

<h1>List of boxes in the request</h1>

@stop

@section('content')



<!-- {{-- Setup data for datatables --}} -->
@php
$heads = [
'#',
'Box name',
'Direction',
'Department',
'content',
'Extreme date',


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
                    $counter = 0;
                    @endphp

                    @foreach($details as $detail)
                    @foreach($detail->boxes as $box)
                    @php $counter++ @endphp
                    <tr>
                        <td>{{$counter}}</td>
                        <td>{!! nl2br(e($box->ref)) !!}</td>
                        <td>{{$detail->archiveRequest->direction->name}}</td>
                        <td>{{$detail->archiveRequest->department->name}}</td>
                        <td>{!! nl2br(e($box->content)) !!}</td>
                        <td>{!! nl2br(e($box->extreme_date)) !!}</td>
                    </tr>
                    @endforeach
                    @endforeach
</x-adminlte-datatable>


@endsection

@section('js')

@stop