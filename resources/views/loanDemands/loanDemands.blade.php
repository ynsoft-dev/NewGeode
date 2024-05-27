@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Loan demand</h1>
<div class="text-center">

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        Add Loan Demand
    </button>

</div>
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
'Loan ID',
'Direction',
'Department',
'Demand Details:',
'Type',
'Request date',
'Return date',
'Status',


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
                    @foreach($loans as $loan)
                    <?php $i++ ?>
                    <tr>
                        <!-- <td>{{$i}}</td> -->
                        <td>{{ $loan->borrow_id }}</td>
                        <td>{{ $loan->Direction->name }}</td>
                        <td>{{$loan->department->name}}</td>
                        <td>{{$loan->box_name}}</td>
                        <td>{{$loan->type}}</td>
                        <td>{{$loan->request_date}}</td>
                        <td>{{$loan->return_date}}</td>
                        <td>
                            @if ($loan->Status == 'created')
                            <span class="badge badge-secondary">{{ $loan->Status }}</span>
                            @elseif($loan->Status == 'Sent')
                            <span class="badge badge-secondary">{{ $loan->Status }}</span>
                            @elseif($loan->Status == 'Accepted')
                            <span class="badge badge-success">{{ $loan->Status }}</span>
                            @elseif($loan->Status == 'Refused')
                            <span class="badge badge-danger">{{ $loan->Status }}</span>
                            @endif
                        
                        </td>

                        <td class="actions-column">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-xs btn-default text-info mx-1 shadow" href="{{ url('loanDetails') }}/{{ $loan->id }}"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                @if ($loan->Status !== 'Sent'&& $loan->Status !== 'Accepted')
                                <a class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete" title="Delete" data-effect="effect-scale" data-id="{{ $loan->id }}" data-name="{{ $loan->box_name }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow" href="{{ url('edit_loan') }}/{{ $loan->id }}"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                                <form id="sendNotificationForm" action="{{ route('loanDemand.store', ['id' => $loan->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" name="sendNotificationButton" class="btn btn-xs btn-default mx-1 shadow" style="border-color: #28a745; color: #6c757d" title="Send notfication" data-effect="effect-scale">
                                        <i class="fas fa-envelope" style="color: #28a745"></i>
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
                <h4 class="modal-title">Add Loan Demand</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('loanDemand.store', ['id' => isset($loan) ? $loan->id : 0, 'check' => true]) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group row mb-0">
                        <div class="col">
                            <div class="form-group">
                                <label for="message-text">Demand Details:</label>
                                <textarea type="text" class="form-control" id="box_name" name="box_name"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Direction</label>
                            <select name="Direction" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                <!--placeholder-->
                                <option value="" selected disabled>Select direction</option>
                                @foreach ($directions as $direction)
                                <option value="{{ $direction->id }}" {{ old('Direction') == $direction->id ? 'selected' : '' }}> {{ $direction->name }}</option>
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


                    <div class="form-group row">
                        <div class="col">
                            <label>Request date</label>
                            <!-- <input class="form-control fc-datepicker" name="box_deposit_date" placeholder="YYYY-MM-DD" type="text" value="{{ date('Y-m-d') }}" required> -->

                            @php
                            $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date name="request_date" :config="$config" placeholder="Choose a date..." required>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>

                        <div class="col">
                            <label>Return date</label>
                            <!-- <input class="form-control fc-datepicker" name="box_deposit_date" placeholder="YYYY-MM-DD" type="text" value="{{ date('Y-m-d') }}" required> -->

                            @php
                            $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date name="return_date" :config="$config" placeholder="Choose a date..." required>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="Original">Original
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="Copy">Copy
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<!-- delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Delete Request Loan</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="loanDemand/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Are you sure you want to delete this request ?</p><br>
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
        $('select[name="Direction"]').on('change', function() {
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
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })
</script>

<script>
    $(document).ready(function() {
        // Fonction pour vérifier si les champs sont remplis
        function checkFields() {
            var name = $('[name="name"]').val();
            var date = $('[name="request_date"]').val();

            if (name.trim() !== '' && date.trim() !== '') {
                // Si les champs sont remplis, activer le bouton
                $('#addBoxBtn').removeClass('disabled');
            } else {
                // Sinon, désactiver le bouton
                $('#addBoxBtn').addClass('disabled');
            }
        }

        // Appeler la fonction lorsque les touches sont relâchées dans les champs
        $('[name="name"], [name="request_date"]').on('input', function() {
            checkFields();
        });

        // Appeler la fonction lors du chargement de la page pour la première fois
        checkFields();
    });
</script>
<script>
    $(document).ready(function() {
        // Fonction pour vérifier si les champs sont remplis
        function checkFields() {
            var name = $('[name="name"]').val();
            var date = $('[name="return_date"]').val();

            if (name.trim() !== '' && date.trim() !== '') {
                // Si les champs sont remplis, activer le bouton
                $('#addBoxBtn').removeClass('disabled');
            } else {
                // Sinon, désactiver le bouton
                $('#addBoxBtn').addClass('disabled');
            }
        }

        // Appeler la fonction lorsque les touches sont relâchées dans les champs
        $('[name="name"], [name="return_date"]').on('input', function() {
            checkFields();
        });

        // Appeler la fonction lors du chargement de la page pour la première fois
        checkFields();
    });
</script>
@stop