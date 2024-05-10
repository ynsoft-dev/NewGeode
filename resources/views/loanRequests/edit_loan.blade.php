@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content_header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Loans</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                edit loan</span>
        </div>
    </div>
</div>
@stop
@section('content')

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- row -->
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ url('loanRequest/update') }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    {{-- 1 --}}

                    <div class="form-group row">
                        <div class="col">
                            <label for="inputName" class="control-label">Box name </label>
                            <input type="hidden" name="loan_Id" value="{{ $loans->id }}">
                            <input type="text" class="form-control" id="inputName" name="box_name" title=" Enter the name of box" value="{{ $loans->box_name }}" required>
                        </div>
                        <div class="col">
                            <label>Request date</label>
                            @php
                            $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date name="request_date" :config="$config" placeholder="Choose a date..." value="{{ $loans->request_date }}" required>
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
                            <label>Return date</label>
                            @php
                            $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date name="return_date" :config="$config" placeholder="Choose a date..." value="{{ $loans->return_date }}" required>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>

                        </div>

                    </div>


                    {{-- 2 --}}

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Direction</label>
                    <select name="Direction" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                        <!--placeholder-->
                        <option value="{{ $loans->direction->id }}">{{ $loans->direction->name }} </option>
                        @foreach ($directions as $direction)
                        <option value="{{ $direction->id }}"> {{ $direction->name }}</option>
                        @endforeach
                    </select>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Department</label>
                    <select id="depart" name="depart" class="form-control">
                        <option value="{{ $loans->depart }}">{{ $loans->department->name }} </option>
                    </select>


                    {{-- 3 --}}

                    <div class="row">
                        <div class="col">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref" for="kind">Kind</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="kind" value="Original" {{ $loans->kind === 'Original' ? 'checked' : '' }}> Original
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="kind" value="Copy" {{ $loans->kind === 'Copy' ? 'checked' : '' }}> Copy
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref" for="membership">Membership</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="Membership" value="Belongs" {{ $loans->Membership === 'Belongs' ? 'checked' : '' }}> Depends on my direction
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="Membership" value="Not" {{ $loans->Membership === 'Not' ? 'checked' : '' }}> Not
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger"> Save</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

</div>

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@stop

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

<!-- <script>
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
</script> -->
@stop