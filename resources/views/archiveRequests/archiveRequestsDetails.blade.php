@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<x-adminlte-card title="Info Request" theme="info" icon="fas fa-lg fa-bell" collapsible maximizable>
    <!-- An info theme card with all the tool buttons... -->

    <p name="name_request"><b>Name of the request : </b> {{ $lastRequest->name }}</p>
    <p name="date_request"><b>Request date : </b> {{ $lastRequest->request_date }}</p>
    <p name="Direction"><b>Direction : </b> {{ $lastRequest->direction->name }}</p>
    <p name="depart"><b>Department : </b> {{ $lastRequest->department->name}}</p>
    <p name="details"><b>Details : </b> {{ $lastRequest->details_request}}</p>
    <p name="box_quantity"><b>Box quantity : </b> {{ $lastRequest->box_quantity}}</p>
    <!-- <p><b>Status : </b> {{ $lastRequest->status }}</p> -->

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

['label' => 'Actions', 'no-export' => true, 'width' => 30],

];

@endphp


@foreach ($requests as $request)
<input type="hidden" name="archive_requests_id" id="archive_requests_id" value="{{ $request->id }}">
@endforeach

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



                    </tr>
                    @endforeach
</x-adminlte-datatable>





@endsection

@section('js')

@stop