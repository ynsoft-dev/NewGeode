@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Columns lists</h1>
<div class="text-center">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
    Add Column
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
          @foreach($columns as $column)
          <?php $i++ ?>
          <tr>
            <td>{{$i}}</td>
            <td>{{$column->name}}</td>
            <td>{{$column->ray->name}}</td>
            <td>{{$column->site->name}}</td>
            <td>
              
              <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $column->id }}" data-name="{{ $column->name }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
            </td>

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
          <select name="Site" class="form-control" required>
            <option value="" selected disabled> -- select site --</option>
            @foreach ($sites as $site)
            <option value="{{ $site->id }}">{{ $site->name }}</option>
            @endforeach
          </select>

          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Ray</label>
          <!-- <select name="ray" id="ray" class="form-control" required>
          </select>  -->


          <select name="ray" id="ray" class="form-control" required>
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



<!-- delete -->
<div class="modal" id="modaldemo8">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-demo">
      <div class="modal-header">
        <h6 class="modal-title">Delete Direction</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="columns/destroy" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <div class="modal-body">
          <p>Are you sure you want to delete this column ?</p><br>
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
              // Append option with ray ID as value
              $('select[name="ray"]').append('<option value="' +
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