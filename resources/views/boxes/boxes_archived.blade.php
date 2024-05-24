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
'Status',

['label' => 'Location', 'no-export' => true, 'width' => 30 ],

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
                        <td>
                            @if($box->status === 'Available')
                            <span class="badge badge-success">{{ ucfirst($box->status) }}</span>
                            @elseif($box->status === 'Non available')
                            <span class="badge badge-danger">{{ ucfirst($box->status) }}</span>
                            @endif
                        </td>



                        <td>

                            {{$box->location}}
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Add location" data-id="{{ $box->id }}" data-toggle="modal" href="#exampleModal2">
                                <i class="fas fa-map-marked-alt fa-custom-size"></i>
                            </a>

                            <!-- <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit location" data-id="{{ $box->id }}" data-toggle="modal" href="#exampleEdit">
                                <i class="fas fa-map-marked-alt fa-custom-size"></i>
                            </a> -->

                            <!-- <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $box->id }}" data-ref="{{ $box->ref }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a> -->
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

<!-- Edit location -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->

<!-- <form action="boxes/update" method="post" autocomplete="off"> -->
<!-- <form action="{{ route('archiveDemand.update', ['id' => 'shelf_id']) }}" method="post" autocomplete="off">

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



            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> -->



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
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
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
    $(document).ready(function() {

        $('select[name="Site"]').on('change', function() {
            var SiteId = $(this).val();
            console.log("site ID:", SiteId);

         

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




@stop