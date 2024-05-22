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

    @if ($demands->status === 'Accepted')
    <p name="response"><b style="color: green;">Response of the demand : </b><span class="badge badge-success">{{ $demands->status }}</span></p>
    @elseif ($demands->status === 'Refused')
    <p name="response"><b style="color: red;">Response of the demand : </b><span class="badge badge-danger">{{ $demands->status }}</span></p>
    <p name="reason" style="color: red;"><b>Reason for the refusal: </b>{{ $demands->reason }}</p>
    @endif

</x-adminlte-card>
@if (($demands->status === 'created' || $demands->status === 'Refused') && !auth()->user()->hasRole('Archiviste'))


<form action="{{ route('archiveDemand.store', ['id' => $demands->id]) }}" method="POST">
    @csrf
    <div class="text-left">
        <button type="submit" name="check_boxes_edit" class="btn btn-secondary" style="width: 110px;">
            <i class="fas fa-arrow-left"></i>
            <span class="ml-1">Back</span>
        </button>
    </div>
</form>

<br>
<!-- <div class="text-left">
    <a href="/archiveDemand" class="btn btn-secondary" style="width: 110px;">
        <i class="fas fa-arrow-left"></i>
        <span class="ml-1">Back</span>
    </a>
</div>
<br> -->

<h1>List of boxes in the demand</h1>

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

@if ($demands->status === 'Sent' && auth()->user()->hasRole('Archiviste'))
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">List of boxes in the demand</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Treat demand</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        @endif
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

                        if (($demands->status === 'created' || $demands->status === 'Refused') && !auth()->user()->hasRole('Archiviste')) {
                        $heads[] = ['label' => 'Actions', 'no-export' => true, 'width' => 15];
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
                                                @if ($demands->status === 'created' || $demands->status === 'Refused' && !auth()->user()->hasRole('Archiviste'))
                                                <td>
                                                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-content="{{ $box->content }}" data-date="{{ $box->extreme_date }}" data-toggle="modal" href="#exampleModal2"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                                                    <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                                                </td>
                                                @endif
                                            </tr>

                                            @endforeach
                                            @endforeach
                        </x-adminlte-datatable>
                        <br>
                        @if ($demands->status === 'Sent')
                    </div>
                    <div class="tab-pane fade text-center" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <div class="my-3">
                            <div class="d-inline-block mx-2">
                                <a class="btn btn-md btn-success shadow" title="Accept" data-effect="effect-scale" data-user="{{$demands->user_id}}" data-id="{{ $demands->id }}" data-name="{{ $demands->name }}" data-toggle="modal" href="#exampleModalAccept">
                                    <i class="fa fa-lg fa-fw fa-check-circle"></i>
                                    Accept demand
                                </a>
                            </div>
                            <div class="d-inline-block mx-2">
                                <a class="btn btn-md btn-danger shadow" title="Refuse" data-effect="effect-scale" data-user="{{$demands->user_id}}" data-id="{{ $demands->id }}" data-toggle="modal" href="#modaldemoRefuse">
                                    <i class="fa fa-lg fa-fw fa-times-circle"></i>
                                    Refuse demand
                                </a>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>

                </div>
            </div>
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


            <!-- Accept demand -->
            <div class="modal" id="exampleModalAccept">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">Accept demand</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('archiveDemand.store', ['id' => $demands->id]) }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>Are you sure you accept this demand ?</p><br>
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="user" id="user" value="">
                                <input class="form-control" name="name" id="name" type="text" readonly>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="sendResponseAEmail" class="btn btn-success"><i class="fas fa-envelope"></i> Confirm and Send response</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Refuse demand -->
            <div class="modal" id="modaldemoRefuse">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">Refuse demand</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('archiveDemand.store', ['id' => $demands->id]) }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>What is the reasons for the rejection? ?</p>
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="user" id="user" value="">
                                <textarea class="form-control" name="reason" id="reason" type="text"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="sendResponseREmail" class="btn btn-success"><i class="fas fa-envelope"></i> Confirm and Send response</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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

            <script>
                $('#exampleModalAccept').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var name = button.data('name');
                    var user = button.data('user');
                    var modal = $(this);
                    modal.find('.modal-body #id').val(id);
                    modal.find('.modal-body #name').val(name);
                    modal.find('.modal-body #user').val(user);
                });
            </script>

            <script>
                $('#modaldemoRefuse').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    // var name = button.data('name');
                    var user = button.data('user');
                    var modal = $(this);
                    modal.find('.modal-body #id').val(id);
                    // modal.find('.modal-body #name').val(name);
                    modal.find('.modal-body #user').val(user);
                });
            </script>
            @stop