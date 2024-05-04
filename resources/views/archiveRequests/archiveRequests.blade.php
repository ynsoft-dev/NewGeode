@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Archive request</h1>
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

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif




<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">


            <div class="card-body">


                <form action="{{ route('archiveRequest.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <div class="form-group row mb-0"> <!-- Ajoutez la classe mb-0 ici -->
                        <div class="col">
                            <x-adminlte-button class="btn-sm float-right mr-2" type="reset" label="Reset" theme="outline-danger" icon="fas fa-trash" width="100px" />
                        </div>
                    </div>

                    <div class="form-group row mt-0"> <!-- Ajoutez la classe mt-0 ici -->
                        <div class="col">
                            <label for="inputName" class="control-label">Name</label>
                            <input type="text" class="form-control" id="inputName" name="name" title="Please enter the name of the request" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col">
                            <label>Box deposit date</label>
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

                    </div>



                    <div class="form-group row">
                        <!-- <div class="col">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div> -->
                        <div class="text-center">
                            <button id="addBoxBtn" type="submit" class="btn btn-primary" style="width: 120px;">
                                <i class="fas fa-plus"></i> Add box
                            </button>

                        </div>
                    </div>

                    <br>






                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
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


@stop