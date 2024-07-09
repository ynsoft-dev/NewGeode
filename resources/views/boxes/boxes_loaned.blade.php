@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

<h1>List of Boxes Loaned</h1>

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

<!-- {{-- Setup data for datatables --}} -->
@php
$heads = [
'#',
'Box name',
'Department',
'Status',
'Location',
'Loan demand number',
'Transmission date',
'Expected return date',
'Overdue',

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
                    @foreach($borrowedBoxes as $box)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$box->ref}}</td>
                        <td>{{$box->archiveRequest->department->name}}</td>
                    
                        <td>
                            @if($box->status === 'Available')
                            <span class="badge badge-success">{{ ucfirst($box->status) }}</span>
                            @elseif($box->status === 'Not available')
                            <span class="badge badge-danger">{{ ucfirst($box->status) }}</span>
                            @endif
                        </td>
                        <td> {{$box->location}}</td>

                        <td> {{$box->request_number}}</td>
                        <td> {{$box->transmission_date}}</td>
                        <td> {{$box->return_date}}</td>
                        <td>
                            @if($box->isOverdue())
                            <span class="badge badge-danger">Overdue</span>
                         
                            @endif
                        </td>
                        <td>
                            <!-- <form action="{{ route('boxes.return', $box->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm bg-gradient-info">Return</button>
                            </form> -->
                            <button class="btn btn-sm bg-gradient-info" data-toggle="modal" data-target="#returnModal" data-id="{{ $box->id }}">Return</button>

                        </td>


                    </tr>
                    @endforeach
</x-adminlte-datatable>
<!-- Modal Retour -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Return Archive Box</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="returnForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="box_id" id="box_id">
                    @php
                    $config = ['format' => 'L'];
                    @endphp
                    <x-adminlte-input-date name="real_return_date" id="real_return_date" :config="$config" placeholder="Choose a date..." required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Return</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
    $('#returnModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var boxId = button.data('id');
        var modal = $(this);
        modal.find('#box_id').val(boxId);
        modal.find('#returnForm').attr('action', '/boxes/' + boxId + '/return');
    });
</script>
@stop