@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<x-adminlte-card title="Info Request" theme="info" icon="fas fa-lg fa-bell" collapsible maximizable>
    <!-- An info theme card with all the tool buttons... -->

    <p name="name_request"><b>Name of the request : </b> {{ $lastRequest->name }}</p>
    <p name="date_request"><b>Request date : </b> {{ $lastRequest->request_date }}</p>
    <!-- <p><b>Status : </b> {{ $lastRequest->status }}</p> -->

</x-adminlte-card>

<h1>List of boxes in the request</h1>
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
        Add box
    </button>
</div>
@stop

@section('content')



<style>
    .modal-dialog {
        max-width: 80%;
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
                        <td>{{$box->direction->name}}</td>
                        <td>{{$box->department->name}}</td>
                        <td>{{$box->content}}</td>
                        <td>{{$box->extreme_date}}</td>



                        <td>
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $box->id }}" data-name="{{ $box->content }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>

                        </td>

                    </tr>
                    @endforeach
</x-adminlte-datatable>


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
                <form action="{{ route('boxesArchiveRequest.store') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}

                    @foreach ($requests as $request)
                    <input type="hidden" name="archive_requests_id" id="archive_requests_id" value="{{ $request->id }}">
                    @endforeach


                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Direction</label>
                    <select name="Direction" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                        <!--placeholder-->
                        <option value="" selected disabled>Select direction</option>
                        @foreach ($directions as $direction)
                        <option value="{{ $direction->id }}"> {{ $direction->name }}</option>
                        @endforeach
                    </select>

                    <!-- @foreach ($departments as $department)
                    <input type="hidden" name="depart_name" id="depart_name" value="{{ $department->name }}">
                    @endforeach -->


                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Department</label>
                    <select id="depart" name="depart" class="form-control">
                    </select>



                    <label for="exampleInputEmail1">Content</label>
                    <textarea class="form-control" id="inputDscrpt" name="content" title="Please enter the content" style="height: 100px;" required></textarea>



                    <label>Extreme date</label>
                    <!-- <input class="form-control fc-datepicker" name="extreme_date" placeholder="YYYY-MM-DD" type="text" required> -->

                    <x-adminlte-input-date name="extreme_date" :config="$config" placeholder="Choose a year..." required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>


                    <!-- <label>Destruction date</label>
                  

                    <x-adminlte-input-date name="destruction_date" :config="$config" placeholder="Choose a year..." required>
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date> -->






                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <h6 class="modal-title">Delete Direction</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="boxesArchiveRequest/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Are you sure you want to delete this box ?</p><br>
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
</script>
@stop