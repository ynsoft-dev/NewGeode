@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Update archive demand</h1>
@stop

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@php
$config = ['format' => 'YYYY'];
@endphp

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('archiveDemand.update', ['id' => $demands->id]) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}

                    <div class="form-group row mb-0">
                        <div class="col">
                            <input type="hidden" name="archive_Id" value="{{ $demands->id }}">
                            <label for="recipient-name" class="col-form-label">Name box:</label>
                            <input class="form-control" name="name" id="name" type="text" value="{{ $demands->name }}" required>
                        </div>

                        <div class="col">
                            <label for="message-text" class="col-form-label">Demand date:</label>
                            @php
                            $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date :config="$config" class="form-control" id="date" name="date" value="{{ now()->format('Y-m-d') }}" required>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Demand details:</label>
                        <textarea type="text" class="form-control" id="details" name="details" required>{{$demands->details_request}}</textarea>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Direction</label>
                            <select name="direction" id="direction" class="custom-select " required>
                                <option value="{{ $demands->direction->id }}">{{ $demands->direction->name }} </option>
                                @foreach ($directions as $direction)
                                <option value="{{ $direction->id }}" required> {{ $direction->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Department</label>
                            <select name="depart" id="depart" class="form-control" required>
                            <option value="{{ $demands->department->id }}">{{ $demands->department->name }} </option>
                                <!-- <option value="{{ $demands->depart }}" >{{ $demands->department->name }} </option> -->
                            </select>
                        </div>
                    </div>

                    <br>

                    <!-- <div class="text-center"> -->
                        <!-- <button name="updateBoxButton" type="submit" class="btn btn-primary" style="width: 130px;">
                            <i class="fa fa-md fa-fw fa-pen"></i> Update box
                        </button> -->
                        <!-- <a href="{{ url('edit_box') }}/{{ $demands->id }}" name="updateBoxButton"  class="btn btn-primary" title="Update"><i class="fa fa-md fa-fw fa-pen"></i> Update box</a> -->

                        <!-- <form action="{{ url('edit_box') }}/{{ $demands->id }}" method="GET">
                            <button type="submit" name="updateBoxButton" class="btn btn-primary" title="Update">
                                <i class="fa fa-md fa-fw fa-pen"></i> Update box
                            </button>
                        </form>
                    </div> -->

                    <div class="text-right">
                        <button name="confirmButton" type="submit" class="btn btn-success" style="width: 120px">
                            <i class="fa fa-md fa-fw fa-check"></i> Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('select[name="direction"]').on('change', function() {
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
@stop