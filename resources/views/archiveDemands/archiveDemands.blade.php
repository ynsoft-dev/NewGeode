@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

<h1>Demands list</h1>
<div class="text-center">

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        <i class="fas fa-plus"></i>
        <span class="ml-1"> Add demand</span>
    </button>


</div>
@stop

@section('content')



<style>
    .modal-dialog {
        max-width: 70%;
        /* max-height: 0%; */
    }

    .badge-orange {
        background-color: orange;
        color: white;
    }

    /* .dataTable .actions-column {
        width: 200px;
    } */
</style>

<body class="{{ session()->has('Add') ? 'sent-successfully' : '' }}">

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
    ['label' => '#', 'width' => 15],
    'Demand name',
    'Demand details',
    'Direction',
    'Department',
    'Demand date',
    'Status',
    'Number of boxes',
    ['label' => 'Actions', 'no-export' => true, 'width' => 0],
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
                        <?php $i = 0 ?>
                        @foreach($demands->sortByDesc('request_date') as $demand)
                        <?php $i++ ?>
                        <tr>
                            <td><b>{{$demand->demand_archive_id}}</b></td>
                            <td>{{$demand->name}}</td>
                            <td>{{$demand->details_request}}</td>
                            <td>{{$demand->direction->name}}</td>
                            <td>{{$demand->department->name}}</td>
                            <td>{{$demand->request_date}}</td>
                            <td>
                                @if($demand->status === 'Accepted')
                                <span class="badge badge-success">{{ ucfirst($demand->status) }}</span>
                                @elseif($demand->status === 'Sent')
                                <span class="badge badge-orange">{{ ucfirst($demand->status) }}</span>
                                @elseif($demand->status === 'created')
                                <span class="badge badge-secondary">{{ ucfirst($demand->status) }}</span>
                                @elseif($demand->status === 'Refused')
                                <span class="badge badge-danger">{{ ucfirst($demand->status) }}</span>
                                @endif
                            </td>

                            <td>{{$demand->getRealBoxQuantity()}}</td>



                            <td class="actions-column">
                                <div class="d-flex align-items-center">
                                    <a href="{{ url('archiveDemandDetails') }}/{{$demand->id}}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details">
                                        <i class="fa fa-lg fa-fw fa-eye"></i>
                                    </a>

                                    @if ($demand->status !== 'Sent' && $demand->status !== 'Accepted')

                                    <a href="{{ url('edit_archive') }}/{{ $demand->id }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update"><i class="fa fa-lg fa-fw fa-pen"></i></a>

                                    <a class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete" title="Delete" data-effect="effect-scale" data-id="{{ $demand->id }}" data-name="{{ $demand->name }}" data-toggle="modal" href="#modaldemo8">
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </a>

                                    <form id="sendEmailForm" action="{{ route('archiveDemand.store', ['id' => $demand->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" name="sendEmailButton" class="btn btn-xs btn-default mx-1 shadow btn-send" style="border-color: #28a745; color: #6c757d; width: auto;">
                                            <i class="fas fa-envelope" style="color: #28a745">Send</i>
                                        </button>
                                    </form>

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach

    </x-adminlte-datatable>


    <!-- Add -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add request</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="myForm" action="{{ route('archiveDemand.store', ['id' => isset($demand) ? $demand->id : 0, 'check' => true]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}
                        <div class="form-group row mb-0"> <!-- Ajoutez la classe mb-0 ici -->
                            <div class="col">
                                <x-adminlte-button class="btn-sm float-right mr-2" type="reset" label="Reset" theme="outline-danger" icon="fas fa-trash" width="100px" />
                            </div>
                        </div>



                        <div class="form-group row mb-0"> <!-- Utilisez la classe mb-0 pour supprimer la marge en bas -->
                            <div class="col">
                                <label for="inputName" class="control-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" title="Please enter the name of the request" required value="{{ old('name') }}">
                            </div>
                            <div class="col">
                                <!-- disabled -->
                                <label>Box deposit date</label>
                                <!-- <input class="form-control fc-datepicker" name="box_deposit_date" placeholder="YYYY-MM-DD" type="text" value="{{ now()->format('Y-m-d') }}" required> -->
                                @php
                                $config = ['format' => 'L'];
                                @endphp
                                <x-adminlte-input-date name="request_date" :config="$config" placeholder="Choose a date..." required value="{{ now()->format('m/d/Y') }}">
                                    <x-slot name="appendSlot">
                                        <div class="input-group-text bg-gradient-danger">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-date>
                            </div>
                        </div>

                        <div class="form-group row"> <!-- Ajoutez la classe mt-0 ici -->
                            <div class="col">
                                <label for="details_request" class="control-label">Details of request</label>
                                <textarea class="form-control" id="details_request" name="details_request" title="Please enter the details of the request" required>{{ old('details_request') }}</textarea>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="inputDirection" class="control-label">Direction</label>
                                <select name="direction" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled>Select direction</option>
                                    @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}" {{ old('direction') == $direction->id ? 'selected' : '' }}> {{ $direction->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputDepartment" class="control-label">Department</label>
                                <select id="depart" name="depart" class="form-control">
                                    <!--placeholder-->
                                    <option value="" selected disabled>Select department</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('depart') == $department->id ? 'selected' : '' }}> {{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- <div class="col">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div> -->
                        <br>
                        <div class="text-center">
                            <button id="addBoxBtn" type="submit" class="btn btn-primary" style="width: 120px;">
                                <i class="fas fa-plus"></i> Add box
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>




    <!-- delete -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete demand</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="archiveDemand/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are you sure you want to delete this demand ?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
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
        $(document).ready(function() {
            $('select[name="direction"]').on('change', function() {
                var DirectionId = $(this).val();
                if (DirectionId) {
                    $.ajax({
                        url: "{{ URL::to('direction') }}/" + DirectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="depart"]').empty();
                            // Values from controller
                            $.each(data, function(key, value) {
                                // Append option with ray ID as value
                                $('select[name="depart"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

    <script>
        // Sélectionnez le bouton Reset dans le formulaire avec l'ID 'myForm'
        document.getElementById('myForm').addEventListener('reset', function() {
            // Réinitialiser la sélection du menu déroulant "depart" en le définissant sur la valeur vide
            document.getElementById('depart').value = '';
        });
    </script>

    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>
    @stop