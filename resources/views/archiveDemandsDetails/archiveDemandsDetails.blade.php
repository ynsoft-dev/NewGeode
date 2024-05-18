@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<x-adminlte-card title="Info Demand" theme="info" icon="fas fa-lg fa-bell" collapsible>
    <!-- An info theme card with all the tool buttons... -->

    <p name="name_request"><b>Name of the demand : </b> {{ $demands->name }}</p>
    <p name="name_user"><b>User : </b>
        @foreach($details as $detail)
        {{ $detail->user}}
        @endforeach
    </p>
    <p name="details_request"><b>Details of the demand : </b> {{ $demands->details_request }}</p>
    <p name="date_request"><b>demand date : </b> {{ $demands->request_date }}</p>
    <p name="Direction"><b>Direction : </b> {{ $demands->direction->name }}</p>
    <p name="depart"><b>Department : </b> {{ $demands->department->name}}</p>

</x-adminlte-card>
@if ($demands->status !== 'Sent')
<div class="text-left">
    <a href="/archiveRequest" class="btn btn-secondary" style="width: 110px;">
        <i class="fas fa-arrow-left"></i>
        <span class="ml-1">Back</span>
    </a>
</div>
<br>
@endif
<h1>List of boxes in the demand</h1>
@if ($demands->status !== 'Sent')
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        <i class="fas fa-plus"> </i>
        <span class="ml-1">Add box</span>
    </button>
</div>
@endif
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

@php
$config = ['format' => 'YYYY'];
@endphp

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


<style>
    .modal-dialog {
        max-width: 50%;
        /* max-height: 0%; */
    }
</style>

<div class=" tab-menu-heading">
    <div class="tabs-menu1">
        <!-- Tabs -->
        <ul class="nav panel-tabs main-nav-line">
            <li><a href="#tab4" class="nav-link active" data-toggle="table1">Demand's informations</a></li>
            <li><a href="#tab5" class="nav-link" data-toggle="tab">Treat demand</a></li>
        </ul>
    </div>
</div>





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

if ($demands->status !== 'Sent') {
$heads[] = ['label' => 'Actions', 'no-export' => true, 'width' => 30];
}
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
                        @if ($demands->status !== 'Sent')
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-content="{{ $box->content }}" data-date="{{ $box->extreme_date }}" data-toggle="modal" href="#exampleModal2"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                        </td>
                        @endif
                    </tr>

                    @endforeach
                    @endforeach
</x-adminlte-datatable>

@if ($demands->status !== 'Sent')
<br>
<form action="{{ route('archiveDemand.store', ['id' => $demands->id]) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success float-right mr-4" style="width: 150px;">Save</button>
    <input type="hidden" name="check_boxes_edit" value="2">
</form>
<br>
<br>
@endif


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
                <form action="{{ route('boxes.store', ['id' => $demands->id]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}


                    <input type="hidden" name="archive_requests_id" id="archive_requests_id" value="{{ $demands->id }}">


                    @foreach($details as $detail)
                    <input type="hidden" name="archieve_request_detail_id" id="archieve_request_detail_id" value="{{ $detail->id }}">
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
                @if(isset($box))
                <form action="{{ route('boxes.update', ['box' => $box->id ]) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="editBoxesD" value="true">
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
            @endif
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
            @if(isset($box))
            <form action="{{ route('boxes.destroy', ['box' => $box->id]) }}" method="post">
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
        @endif
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