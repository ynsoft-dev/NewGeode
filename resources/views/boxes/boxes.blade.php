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

    <!-- <p><b>Status : </b> {{ $lastRequest->status }}</p> -->

</x-adminlte-card>

<h1>List of boxes in the request</h1>
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        <i class="fas fa-plus"> </i>
        <span class="ml-1">Add box</span>
    </button>
</div>
@stop

@section('content')



<style>
    .modal-dialog {
        max-width: 70%;
        /* max-height: 0%; */
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

['label' => 'Actions', 'no-export' => true, 'width' => 30],

];

@endphp


@foreach ($demands as $demand)
<input type="hidden" name="archive_requests_id" id="archive_requests_id" value="{{ $demand->id }}">
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



                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-content="{{$box->content}}" data-date="{{$box->extreme_date}}" data-toggle="modal" href="#exampleModal2"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                        </td>

                    </tr>
                    @endforeach
</x-adminlte-datatable>




<br><br>
<form action="{{ route('archiveRequest.store', ['id' => $lastRequest->id]) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success float-right mr-4" style="width: 150px;">Save</button>
    <input type="hidden" name="check_boxes" value="1">
</form>


<br><br><br>


<!-- Add -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Box</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('boxes.store', ['id' => $lastRequest->id]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}

                    @foreach ($demands as $demand)
                    <input type="hidden" name="archive_requests_id" id="archive_requests_id" value="{{ $demand->id }}">
                    @endforeach

                    @foreach ($demandsDetail as $demandDetail)
                    <input type="hidden" name="archieve_request_detail_id" id="archieve_request_detail_id" value="{{ $demandDetail->id }}">
                    @endforeach


                    <label for="exampleInputEmail1">Box name</label>
                    <input class="form-control" id="inputDscrpt" name="ref" title="Please enter the box name" required></input>


                    <label for="exampleInputEmail1">Content</label>
                    <textarea class="form-control" id="inputDscrpt" name="content" title="Please enter the content" style="height: 100px;" required></textarea>




                    <label>Extreme date</label>


                    <x-adminlte-input-date name="extreme_date" :config="$config" placeholder="Choose a year..." required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>


<!-- Edit -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Box</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="boxes/update" method="post" autocomplete="off">
                    
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="editBoxes" value="true">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <label for="recipient-name" class="col-form-label">Name box:</label>
                        <input class="form-control" name="ref" id="ref" type="text">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Content:</label>
                        <textarea type="text" class="form-control" id="content" name="content"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Extreme date:</label>
                        <x-adminlte-input-date :config="$config" class="form-control" id="date" name="date">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-danger">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>

            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete Box</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="boxes/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Are you sure you want to delete this box ?</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="ref" id="ref" type="text" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
        </div>
        </form>
    </div>
</div>

@endsection

@section('js')

<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var ref = button.data('ref')
        var content = button.data('content')
        var date = button.data('date')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #ref').val(ref);
        modal.find('.modal-body #content').val(content);
        modal.find('.modal-body #date').val(date);
    })
</script>

<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var ref = button.data('ref')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #ref').val(ref);
    })
</script>

@stop