@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Shelves lists</h1>
<div class="text-center">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
    Add Shelf
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
'#',
'name',
'country',
'state',
'city',

['label' => 'Actions', 'no-export' => true, 'width' => 30],
];

@endphp

<x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
  @php
  $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
      <"row" <"col-12" tr> >
        <"row" <"col-sm-12 d-flex justify-content-start" f> >';
          $config['paging'] = false;
          $config["lengthMenu"] = [ 10, 50, 100, 500];
          @endphp
          <?php $i = 0     ?>
          @foreach($shelves as $shelf)
          <?php $i++ ?>
          <tr>
            <td>{{$i}}</td>
            <td>{{$shelf->name}}</td>
            <td>{{$shelf->column}}</td>
            <td>{{$shelf->ray}}</td>
            <td>{{$shelf->site->name}}</td>


          </tr>
          @endforeach
</x-adminlte-datatable>




<!-- Add -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Column</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('columns.store') }}" method="post" autocomplete="off">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="exampleInputEmail1">Name Column:</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>

          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Site</label>
          <select id="country-dropdown" class="form-control">

            <option value="">-- Select Country --</option>

            @foreach ($countries as $data)

            <option value="{{$data->id}}">

              {{$data->name}}

            </option>

            @endforeach

          </select>

          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Ray</label>
          <select id="state-dropdown" class="form-control">

          </select>>

          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Column</label>
          <select id="city-dropdown" class="form-control">

          </select>

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

@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    $(document).ready(function () {



        /*------------------------------------------

        --------------------------------------------

        Country Dropdown Change Event

        --------------------------------------------

        --------------------------------------------*/

        $('#country-dropdown').on('change', function () {

            var idCountry = this.value;

            $("#state-dropdown").html('');

            $.ajax({

                url: "{{url('api/fetch-states')}}",

                type: "POST",

                data: {

                    country_id: idCountry,

                    _token: '{{csrf_token()}}'

                },

                dataType: 'json',

                success: function (result) {

                    $('#state-dropdown').html('<option value="">-- Select State --</option>');

                    $.each(result.states, function (key, value) {

                        $("#state-dropdown").append('<option value="' + value

                            .id + '">' + value.name + '</option>');

                    });

                    $('#city-dropdown').html('<option value="">-- Select City --</option>');

                }

            });

        });



        /*------------------------------------------

        --------------------------------------------

        State Dropdown Change Event

        --------------------------------------------

        --------------------------------------------*/

        $('#state-dropdown').on('change', function () {

            var idState = this.value;

            $("#city-dropdown").html('');

            $.ajax({

                url: "{{url('api/fetch-cities')}}",

                type: "POST",

                data: {

                    state_id: idState,

                    _token: '{{csrf_token()}}'

                },

                dataType: 'json',

                success: function (res) {

                    $('#city-dropdown').html('<option value="">-- Select City --</option>');

                    $.each(res.cities, function (key, value) {

                        $("#city-dropdown").append('<option value="' + value

                            .id + '">' + value.name + '</option>');

                    });

                }

            });

        });



    });

</script>
@stop