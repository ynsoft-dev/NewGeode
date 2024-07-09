@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

<h1>List of boxes</h1>

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
<?php session()->forget('delete'); ?>

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<?php session()->forget('edit'); ?>


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
'Destruction',
'Status',

['label' => 'Location', 'no-export' => true, 'width' => 23 ],
['label' => 'Actions', 'no-export' => true, 'width' => 10],

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
                    @foreach($boxes as $box)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$box->ref}}</td>
                        <td>{{$box->archiveRequest->direction->name}}</td>
                        <td>{{$box->archiveRequest->department->name}}</td>
                        <td>{!! nl2br(e($box->content)) !!}</td>
                        <td>{{$box->extreme_date}}</td>
                        <td>{{$box->destruction_date}}</td>
                        <td>
                            @if($box->status === 'Available')
                            <span class="badge badge-success">{{ ucfirst($box->status) }}</span>
                            @elseif($box->status === 'Not available')
                            <span class="badge badge-danger">{{ ucfirst($box->status) }}</span>
                            @endif
                        </td>



                        <td>

                            {{$box->location}}


                            @if($box->location !== null)
                            <a href="{{ url('boxArchived_edit') }}/{{ $box->id }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit location">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>

                            <!-- <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit location" data-id="{{ $box->id }}" data-toggle="modal" href="#modalEdit">
                                <i class="fas fa-map-marked-alt fa-custom-size"></i>
                            </a> -->
                            @else

                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Add location" data-id="{{ $box->id }}" data-toggle="modal" href="#exampleModal2">
                                <i class="fas fa-map-marked-alt fa-custom-size"></i>
                            </a>
                            @endif

                        </td>

                        <td class="actions-column">
                            <div class="d-flex align-items-center">

                                @if ($box->status === 'Available' )
                                <x-adminlte-button label="Borrow" class="btn-sm bg-gradient-info" type="button" title="Emprunter" data-toggle="modal" data-target="#borrowModal" data-id="{{ $box->id }}" style="width: 60px;" />

                                <x-adminlte-button label="Plan destruction" class="btn-sm bg-gradient-danger" type="button" title="plan destruction" data-toggle="modal" data-target="#destroyModal" data-id="{{ $box->id }}" style="width: 120px;" />
                                @endif
                            </div>
                        </td>

                    </tr>
                    @endforeach
</x-adminlte-datatable>






<!-- Add location -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <form action="boxes/update" method="post" autocomplete="off"> -->
                <form action="boxArchived/update" method="post" autocomplete="off">

                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Site</label>
                    <select name="Site" class="form-control" required>
                        <option value="" selected disabled> -- Select site --</option>
                        @foreach ($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Ray</label>
                    <select name="ray" id="ray" class="form-control" required>
                    </select>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Column</label>
                    <select name="column" id="column" class="form-control" required>
                    </select>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Shelf</label>
                    <select name="shelf" id="shelf" class="form-control" required>
                    </select>

                    <input type="hidden" name="location" id="location">

                    <input type="hidden" name="siteId" id="siteId">
                    <input type="hidden" name="ray_id" id="ray_id">
                    <input type="hidden" name="column_id" id="column_id">
                    <input type="hidden" name="shelf_id" id="shelf_id">



            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajoutez ces champs cachés pour stocker les données -->
<input type="hidden" id="loan_demand_numbers" value="{{ json_encode($loanDemandNumbers) }}">
<input type="hidden" id="loan_return_dates" value="{{ json_encode($returnDates) }}">
<input type="hidden" id="loan_request_dates" value="{{ json_encode($requestDates) }}">



<!-- Modal Emprunter -->
<div class="modal fade" id="borrowModal" tabindex="-1" role="dialog" aria-labelledby="borrowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowModalLabel">Borrow archive box</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="borrowForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                  
                    <input type="hidden" name="box_id" id="box_id">
                    <div class="form-group">
                        <label for="request_number">Loan demand number</label>
                        <select class="form-control" id="request_number" name="request_number" required>
                            <option value="">Select a loan demand number</option>
                            @foreach($loanDemandNumbers as $id => $borrowId)
                            <option value="{{ $borrowId }}">{{ $borrowId }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label>Transmission date</label>
                    @php
                    $config = ['format' => 'L'];
                    @endphp
                    <x-adminlte-input-date name="transmission_date" id="transmission_date" :config="$config" placeholder="Choose a transmission date" required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>

                    <label>Expected return date</label>
                    @php
                    $config = ['format' => 'L'];
                    @endphp
                    <x-adminlte-input-date name="return_date" id="return_date" :config="$config" placeholder="Choose an Expected return date" required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Borrow</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal pour détruire la boîte -->
<div class="modal fade" id="destroyModal" tabindex="-1" role="dialog" aria-labelledby="destroyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destroyModalLabel">Plan the destruction of archive boxes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="destroyForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="box_id" id="box_id">
                    <div class="form-group row">
                        <div class="col">

                            <label>
                                <input type="radio" name="destruction_option" value="planned_in" checked> Planned in
                            </label>

                            @php
                            $config = ['format' => 'YYYY'];
                            @endphp
                            <x-adminlte-input-date name="destruction_date" id="destruction_date" :config="$config" placeholder="Choisir une année..." required>
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




@endsection

@section('js')





<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>


<script>
    $('#borrowModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #box_id').val(id);
        modal.find('form').attr('action', '/boxes/' + id + '/borrow');
    })
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loanReturnDates = JSON.parse(document.getElementById('loan_return_dates').value);
        const loanRequestDates = JSON.parse(document.getElementById('loan_request_dates').value);


        const requestNumberSelect = document.getElementById('request_number');
        const returnDateInput = document.getElementById('return_date');
        const transmissionDateInput = document.getElementById('transmission_date');


        requestNumberSelect.addEventListener('change', function() {
            const selectedBorrowId = requestNumberSelect.value;

            if (loanReturnDates[selectedBorrowId]) {
                returnDateInput.value = loanReturnDates[selectedBorrowId];
            } else {
                returnDateInput.value = '';
            }
            if (loanRequestDates[selectedBorrowId]) {
                transmissionDateInput.value = loanRequestDates[selectedBorrowId];
            } else {
                transmissionDateInput.value = '';
            }
        });
    });
</script>

<script>
    $('#destroyModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var boxId = button.data('id');
        var modal = $(this);
        modal.find('.modal-body #box_id').val(boxId);
        modal.find('form').attr('action', '/boxes/' + boxId + '/destroy');
    });
</script>

<script>
    // Désactive le champ de sélection de date lorsque l'option "Illimitée" est sélectionnée
    $('#unlimitedOption').change(function() {
        if ($(this).is(':checked')) {
            $('#destruction_date').val('').attr('disabled', true);
        } else {
            $('#destruction_date').attr('disabled', false);
        }
    });

    // Désactive ou active le champ de sélection de date en fonction de l'option sélectionnée
    $('input[name="destruction_option"]').change(function() {
        if ($(this).val() === 'planned_in') {
            $('#destruction_date').removeAttr('disabled').focus();
        } else {
            $('#destruction_date').val('').attr('disabled', true);
        }
    });
</script>





<script>
    $(document).ready(function() {

        var siteId = $('select[name="Site"]').val();
        console.log("site IDDDD:", siteId);
        $('#siteId').val(siteId)

        var selectedRayId = $('select[name="ray"]').val();
        console.log("Selected Ray ID:", selectedRayId);

        $('#ray_id').val(selectedRayId);

        $('select[name="Site"]').on('change', function() {
            var SiteId = $(this).val();
            console.log("site ID:", SiteId);
            $('#siteId').val(SiteId);

            var siteName = $('select[name="Site"] option:selected').text();
            console.log("siteName:", siteName);

            if (SiteId) {
                console.log("Déclenchement de la requête AJAX pour récupérer les rayons");
                $.ajax({
                    url: "{{ URL::to('boxArchived/site') }}/" + SiteId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {



                        $('select[name="ray"]').empty();
                        // Values from controller
                        $.each(data, function(id, name) {
                            $('select[name="ray"]').append('<option value="' +
                                id + '">' + name + '</option>');
                        });



                        var selectedRayId = $('select[name="ray"]').val();
                        console.log("Selected Ray ID:", selectedRayId);

                        $('#ray_id').val(selectedRayId);

                        var rayName = $('select[name="ray"] option:selected').text();
                        console.log("rayName:", rayName);


                        if (selectedRayId) {
                            // Vérification si la deuxième requête AJAX est déclenchée
                            console.log("Déclenchement de la requête AJAX pour récupérer les colonnes");
                            $.ajax({
                                url: "{{ URL::to('boxArchived/col') }}/" + selectedRayId,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="column"]').empty();
                                    $.each(data, function(id, name) {
                                        $('select[name="column"]').append('<option value="' + id + '">' + name + '</option>');
                                    });


                                    var selectedColumnId = $('select[name="column"]').val();
                                    console.log("Selected column ID:", selectedColumnId);

                                    $('#column_id').val(selectedColumnId);

                                    var columnName = $('select[name="column"] option:selected').text();
                                    console.log("Column name", columnName);

                                    if (selectedColumnId) {
                                        // Vérification si la deuxième requête AJAX est déclenchée
                                        console.log("Déclenchement de la requête AJAX pour récupérer les étagères");
                                        $.ajax({
                                            url: "{{ URL::to('boxArchived/shelves') }}/" + selectedColumnId,
                                            type: "GET",
                                            dataType: "json",
                                            success: function(data) {
                                                $('select[name="shelf"]').empty();
                                                $.each(data, function(id, name) {
                                                    $('select[name="shelf"]').append('<option value="' + id + '">' + name + '</option>');
                                                });

                                                var shelfName = $('select[name="shelf"] option:selected').text();
                                                console.log("Shelfname ", shelfName);


                                                var shelf_id = $('select[name="shelf"] option:selected').val();
                                                console.log("shelfid ", shelf_id);
                                                $('#shelf_id').val(shelf_id);

                                                var location = siteName + '-' + rayName + '-' + columnName + '-' + shelfName;
                                                console.log(location);
                                                $('#location').val(location);
                                            },

                                        });



                                    } else {
                                        console.log('AJAX load did not work');
                                    }
                                },
                            });

                        } else {
                            console.log('AJAX load did not work');
                        }
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }


        });


    });
</script>

<script>
    $('select[name="ray"]').on('change', function() {

        var siteName = $('select[name="Site"] option:selected').text();
        console.log("siteName:", siteName);



        var selectedRayId = $('select[name="ray"]').val();
        console.log("Selected Ray ID:", selectedRayId);

        $('#ray_id').val(selectedRayId);

        var rayName = $('select[name="ray"] option:selected').text();
        console.log("rayNameeeeeeeee:", rayName);

        if (selectedRayId) {
            // Vérification si la deuxième requête AJAX est déclenchée
            console.log("Déclenchement de la requête AJAX pour récupérer les colonnes");
            $.ajax({
                url: "{{ URL::to('boxArchived/col') }}/" + selectedRayId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="column"]').empty();
                    $.each(data, function(id, name) {
                        $('select[name="column"]').append('<option value="' + id + '">' + name + '</option>');
                    });


                    var selectedColumnId = $('select[name="column"]').val();
                    console.log("Selected column ID:", selectedColumnId);

                    $('#column_id').val(selectedColumnId);

                    var columnName = $('select[name="column"] option:selected').text();
                    console.log("Column name", columnName);

                    if (selectedColumnId) {
                        // Vérification si la deuxième requête AJAX est déclenchée
                        console.log("Déclenchement de la requête AJAX pour récupérer les étagères");
                        $.ajax({
                            url: "{{ URL::to('boxArchived/shelves') }}/" + selectedColumnId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="shelf"]').empty();
                                $.each(data, function(id, name) {
                                    $('select[name="shelf"]').append('<option value="' + id + '">' + name + '</option>');
                                });



                                var shelf_id = $('select[name="shelf"] option:selected').val();
                                console.log("shelfid ", shelf_id);
                                $('#shelf_id').val(shelf_id);

                                var shelfName = $('select[name="shelf"] option:selected').text();
                                console.log("Shelfnameeeeeeeee********************* ", shelfName);

                                var location = siteName + '-' + rayName + '-' + columnName + '-' + shelfName;
                                console.log(location);
                                $('#location').val(location);


                            },

                        });



                    } else {
                        console.log('AJAX load did not work');
                    }
                },
            });

        } else {
            console.log('AJAX load did not work');
        }
    });
</script>

<script>
    $('select[name="ray"]').on('change', function() {
        var selectedRayId = $('#ray').val();
        console.log("Selected Ray ID:", selectedRayId);

        $('#ray_id').val(selectedRayId);

        if (selectedRayId) {
            // Vérification si la deuxième requête AJAX est déclenchée
            console.log("Déclenchement de la requête AJAX pour récupérer les colonnes");
            $.ajax({
                url: "{{ URL::to('boxArchived/col') }}/" + selectedRayId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="column"]').empty();
                    $.each(data, function(id, name) {
                        $('select[name="column"]').append('<option value="' + id + '">' + name + '</option>');
                    });

                },
            });

            $('select[name="column"]').on('change', function() {
                    var selectedColumnId = $('#column').val();
                    console.log("Selected column ID:", selectedColumnId);

                    $('#column_id').val(selectedColumnId);

                    if (selectedColumnId) {
                        // Vérification si la deuxième requête AJAX est déclenchée
                        console.log("Déclenchement de la requête AJAX pour récupérer les étagères");
                        $.ajax({
                            url: "{{ URL::to('boxArchived/shelves') }}/" + selectedColumnId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="shelf"]').empty();
                                $.each(data, function(id, name) {
                                    $('select[name="shelf"]').append('<option value="' + id + '">' + name + '</option>');
                                });




                                var shelf_id = $('select[name="shelf"] option:selected').val();
                                console.log("shelfid ", shelf_id);
                                $('#shelf_id').val(shelf_id);


                            },

                        });



                    } else {
                        console.log('AJAX load did not work');
                    }
                }

            );
        } else {
            console.log('AJAX load did not work');
        }
    });
</script>

<script>
    $('select[name="column"]').on('change', function() {
        var selectedColumnId = $('#column').val();
        console.log("Selected column ID:", selectedColumnId);

        $('#column_id').val(selectedColumnId);

        if (selectedColumnId) {
            // Vérification si la deuxième requête AJAX est déclenchée
            console.log("Déclenchement de la requête AJAX pour récupérer les étagères");
            $.ajax({
                url: "{{ URL::to('boxArchived/shelves') }}/" + selectedColumnId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="shelf"]').empty();
                    $.each(data, function(id, name) {
                        $('select[name="shelf"]').append('<option value="' + id + '">' + name + '</option>');
                    });

                    var shelf_id = $('select[name="shelf"] option:selected').val();
                    console.log("shelfid ", shelf_id);
                    $('#shelf_id').val(shelf_id);


                },

            });



        } else {
            console.log('AJAX load did not work');
        }
    });
</script>

<script>
    $(document).ready(function() {

        $(('select[name="Site"] , select[name="ray"], select[name="column"], select[name="shelf"]')).on('change', function() {

            var siteName = $('select[name="Site"] option:selected').text();
            console.log(siteName);
            var rayName = $('select[name="ray"] option:selected').text();
            console.log(rayName);
            var columnName = $('select[name="column"] option:selected').text();
            console.log(columnName);
            var shelfName = $('select[name="shelf"] option:selected').text();
            console.log(shelfName);

            var location = siteName + '-' + rayName + '-' + columnName + '-' + shelfName;

            $('#location').val(location);
            console.log(location);
        });

    });
</script>

<script>
    $(document).ready(function() {

        $(('select[name="shelf"]')).on('change', function() {
            // var shelf_id = $('select[name="shelf"] option:selected').val();
            // console.log("shelfIddd", shelf_id);
            // $('#shelf_id').val(shelf_id);

            var shelfName = $('select[name="shelf"] option:selected').text();
            console.log("Shelfname ", shelfName);


            var shelf_id = $('select[name="shelf"] option:selected').val();
            console.log("shelfid ", shelf_id);
            $('#shelf_id').val(shelf_id);

            var location = siteName + '-' + rayName + '-' + columnName + '-' + shelfName;
            console.log(location);
            $('#location').val(location);
        });

    });
</script>



@stop