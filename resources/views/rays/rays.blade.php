@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ __('boxflow.raysList') }}</h1>
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 170px;">
            {{ __('boxflow.addRay') }}
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
    $heads = ['#', 'Désignation', 'Salle', ['label' => 'Actions', 'no-export' => true, 'width' => 30]];
@endphp
<!-- {{-- Minimal example / fill data using the component slot --}} -->
<x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
    @php
        $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
      <"row" <"col-12" tr> >
        <"row" <"col-sm-12 d-flex justify-content-start" f> >';
        $config['paging'] = false;
        $config['lengthMenu'] = [10, 50, 100, 500];
    @endphp
    <?php $i = 0; ?>
    @foreach ($rays as $x)
        <?php $i++; ?>
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $x->name }}</td>
            <td>{{ $x->site->name }}</td>
            <td>
                <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Update" data-effect="effect-scale"
                    data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                    data-site_name="{{ $x->site->name }}" data-toggle="modal" href="#exampleModal2"><i
                        class="fa fa-lg fa-fw fa-pen"></i></a>
                <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale"
                    data-id="{{ $x->id }}" data-name="{{ $x->name }}" data-toggle="modal"
                    href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
            </td>
        </tr>
    @endforeach

</x-adminlte-datatable>

<!-- Add -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('boxflow.addRay') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rays.store') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('boxflow.nameRay') }}</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">{{ __('boxflow.site') }}</label>
                    <select name="site_id" id="site_id" class="form-control" required>
                        <option value="" selected disabled> -- {{ __('boxflow.selectSite') }} --</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{ __('boxflow.confirm') }}</button>
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('boxflow.close') }}</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


</div>

<!-- edit -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('boxflow.editRay') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="rays/update" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <label for="recipient-name" class="col-form-label">{{ __('boxflow.name') }}</label>
                        <input class="form-control" name="name" id="name" type="text">
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">{{ __('boxflow.site') }}</label>
                    <select name="site_name" id="site_name" class="custom-select my-1 mr-sm-2" required>
                        @foreach ($sites as $site)
                            <option>{{ $site->name }}</option>
                        @endforeach

                    </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('boxflow.confirm') }}</button>
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ __('boxflow.close') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('boxflow.deleteRay') }}</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="rays/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>{{ __('boxflow.confirmDelete') }}</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="name" id="name" type="text" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('boxflow.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('boxflow.confirm') }}</button>
                </div>
        </div>
        </form>
    </div>
</div>

@stop

@section('js')
<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var site_name = button.data('site_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #site_name').val(site_name);
    })
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
