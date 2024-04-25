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
'ray',
'site',
'column',

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
        <form action="{{ route('shelves.store') }}" method="post" autocomplete="off">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="exampleInputEmail1">Name Column:</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>

          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Site</label>
          <select name="Site" class="form-control" required>
            <option value="" selected disabled> -- select site --</option>
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
<script>
  $(document).ready(function() {

    $('select[name="Site"]').on('change', function() {
      var SiteId = $(this).val();
      if (SiteId) {
        $.ajax({
          url: "{{ URL::to('site') }}/" + SiteId,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $('select[name="ray"]').empty();
            // Values from controller
            $.each(data, function(key, value) {
              $('select[name="ray"]').append('<option value="' +
                value + '">' + value + '</option>');
            });
          },
        });
      } else {
        console.log('AJAX load did not work');
      }
    });




    $('select[name="ray"]').on('change', function() {
    var rayId = $(this).val();
    console.log("Ray ID:", rayId); // Ajoutez cette ligne pour vérifier la valeur de l'ID du rayon
    if (rayId) {
        $.ajax({
            url: "{{ URL::to('ray-columns') }}/" + rayId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('select[name="column"]').empty();
                // Values from controller
                $.each(data.columns, function(key, value) {
                    $('select[name="column"]').append('<option value="' +
                        value.id + '">' + value.name + '</option>');
                });
            },
        });
    } else {
        console.log('AJAX load did not work');
    }
});




  });
</script>
@stop