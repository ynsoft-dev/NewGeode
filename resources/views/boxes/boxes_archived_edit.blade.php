@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1></h1>
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
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-8">
        <div class="card">
            <div class="card-body ">
                <div class="card-body d-flex justify-content-center">

                    <form class="w-75" action="{{ route('boxArchived.update', ['id' => $boxes->id]) }}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <h3>Update box location</h3>
                        <br>
                        <input type="hidden" name="id" id="id" value="{{ $boxes->id }}">
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Site</label>


                        <select name="Site" id="Site" class="custom-select" required>
                            <option value="{{ $boxes->shelf->site->id }}">{{ $boxes->shelf->site->name }}</option>
                            @foreach ($sites as $site)

                            @if ($site->id !== $boxes->shelf->site->id)
                            <option value="{{ $site->id }}" required>{{ $site->name }}</option>
                            @endif


                            @endforeach
                        </select>





                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Ray</label>
                        <select name="ray" id="ray" class="form-control" required>
                            <option value="{{$boxes->shelf->ray->id}}">{{ $boxes->shelf->ray->name }} </option>

                          
                            @foreach ($rays as $ray)
                            @if ($ray->id !== $boxes->shelf->ray->id)
                            <option value="{{$ray->id}}" required> {{ $ray->name }} </option>
                            @endif

                            @endforeach
                        </select>

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Column</label>
                        <select name="column" id="column" class="form-control" required>
                            <option value="{{$boxes->shelf->column->id}}">{{ $boxes->shelf->column->name }} </option>
                            @foreach ($columns as $column)

                            @if ($column->id !== $boxes->shelf->column->id)
                            <option value="{{$column->id}}" required>{{ $column->name }} </option>
                            @endif

                            @endforeach
                        </select>

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Shelf</label>
                        <select name="shelf" id="shelf" class="form-control" required>
                            <option value="{{$boxes->shelf->id}}">{{ $boxes->shelf->name }} </option>
                            @foreach ($shelves as $shelf)

                            @if ($shelf->id !== $boxes->shelf->id)
                            <option value="{{$shelf->id}}" required> {{ $shelf->name }} </option>
                            @endif
                            
                            @endforeach
                        </select>

                        <input type="hidden" name="location" id="location">
                       


                        <input type="hidden" name="siteId" id="siteId">
                        <input type="hidden" name="ray_id" id="ray_id">
                        <input type="hidden" name="column_id" id="column_id">
                        <input type="hidden" name="shelf_id" id="shelf_id">


                        <div class="card-footer text-center">
                            <button type="submit" name="editLocation" class="btn btn-primary">Confirm</button>
                            <button type="button" class="btn btn-secondary">Close</button>
                        </div>
                    </form>

                </div>

            </div>


        </div>
    </div>
</div>
<br>
@endsection

@section('js')
<script>
    $(document).ready(function() {

        var siteId = $('select[name="Site"]').val();
        console.log("site IDDDD:", siteId);
        $('#siteId').val(siteId);

        var siteName = $('select[name="Site"] option:selected').text();
        console.log("siteName:", siteName);

        var selectedRayId = $('select[name="ray"]').val();
        console.log("Selected Ray ID:", selectedRayId);
        $('#ray_id').val(selectedRayId);

        var rayName = $('select[name="ray"] option:selected').text();
        console.log("rayName:", rayName);

        var selectedColumnId = $('select[name="column"]').val();
        console.log("Selected column ID:", selectedColumnId);
        $('#column_id').val(selectedColumnId);

        var columnName = $('select[name="column"] option:selected').text();
        console.log("Column name", columnName);

        var shelf_id = $('select[name="shelf"] option:selected').val();
        console.log("shelfid ", shelf_id);
        $('#shelf_id').val(shelf_id);

        var shelfName = $('select[name="shelf"] option:selected').text();
        console.log("Shelfname ", shelfName);


        var location = siteName + '-' + rayName + '-' + columnName + '-' + shelfName;
        console.log(location);
        $('#location').val(location);


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
        var siteId = $('select[name="Site"]').val();
        console.log("site IDDDD:", siteId);
        $('#siteId').val(siteId);

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
    $('select[name="shelf"]').on('change', function() {
        var shelf_id = $('select[name="shelf"] option:selected').val();
                    console.log("shelfid ", shelf_id);
                    $('#shelf_id').val(shelf_id);
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



@stop