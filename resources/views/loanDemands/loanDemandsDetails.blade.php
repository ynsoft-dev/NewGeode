@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Loan Demand Details</h1>




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

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif


<!-- row opened -->
<div class="row row-sm">

    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->get('activeTab') === 'tab1' ? 'active' : '' }}" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Loan Demand's Details</a>
                                        </li>
                                        @if ($loans->Status === 'Sent' && auth()->user()->hasRole('Archiviste')) <li class="nav-item">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->get('activeTab') === 'tab2' ? 'active' : '' }}" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Loan Demand Response</a>
                                        </li>
                                        @endif
                                        @if(($loans->type !== 'Original' && $loans->Status === 'Accepted')||($loans->Status === 'Sent' && auth()->user()->hasRole('Archiviste') && $loans->type !== 'Original'))
                                        <li class="nav-item">
                                            <a id="tab3-link" class="nav-link {{ request()->get('activeTab') === 'tab3' ? 'active' : '' }} " data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false" disabled>Loan Attachment</a>
                                        </li>
                                        @endif

                                    </ul>


                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane {{ request()->get('activeTab') === 'tab1' ? 'active' : '' }}" id="tab1">
                                        <div class="table-responsive mt-15">


                                            <x-adminlte-card title="Info Demand" theme="info" icon="fas fa-lg fa-bell" collapsible>
                                                <!-- An info theme card with all the tool buttons... -->

                                                <p><b>ID Loan:</b> {{ $loans->borrow_id}}</p>
                                                <p><b>Type of loan: </b>{{ $loans->type }}</p>
                                                <p><b>Request date: </b>{{ $loans->request_date }}</p>
                                                <p><b>Return date: </b> {{ $loans->return_date }}</p>
                                                <p><b>Direction : </b> {{ $loans->Direction->name }}</p>
                                                <p><b>Departement : </b> {{ $loans->department->name }}</p>
                                                <p><b>Demand Details : </b>{{ $loans->box_name }}</p>
                                                <p><b>User : </b>
                                                    @foreach($details as $detail)
                                                    {{ $detail->user}}
                                                    @endforeach
                                                </p>
                                                @if ($loans->Status === 'Accepted')
                                                <p name="response"><b style="color: green;">Response of the demand : </b><span class="badge badge-success">{{ $loans->Status }}</span></p>
                                                @elseif ($loans->Status === 'Refused')
                                                <p name="response"><b style="color: red;">Response of the demand : </b><span class="badge badge-danger">{{ $loans->Status }}</span></p>
                                                <p name="reason" style="color: red;"><b>Reason for the refusal: </b>{{ $loans->reason }}</p>
                                                @endif

                                            </x-adminlte-card>

                                        </div>

                                    </div>
                                    <div class="tab-pane {{ request()->get('activeTab') === 'tab2' ? 'active' : '' }}" id="tab2">
                                        <div class="text-center" style="margin-top: 30px;margin-bottom: 50px; ">

                                            <button type="button" class="btn btn-md btn-success shadow" style="width: 170px; margin-right: 50px;" title="Accept demande" data-user="{{$loans->user_id}}" data-id="{{ $loans->id }}" data-name="{{ $loans->name }}" data-toggle="modal" data-target="#acceptModal">
                                                <i class="fa fa-lg fa-fw fa-check-circle"></i>
                                                Accept Demand
                                            </button>
                                            <button type="button" class="btn btn-md btn-danger shadow" style="width: 170px;" title="Refuse demande" data-user="{{$loans->user_id}}" data-id="{{ $loans->id }}" data-toggle="modal" data-target="#rejectModal">
                                                <i class="fa fa-lg fa-fw fa-times-circle"></i>
                                                Refuse Demand
                                            </button>

                                        </div>

                                        <!-- Modal pour l'acceptation -->
                                        <div class="modal" id="acceptModal">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Accept demand</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{ route('loanDemand.store', ['id' => $loans->id]) }}" method="post">
                                                        {{ csrf_field() }}

                                                        <div class="modal-body">
                                                            <p>Are you sure you accept this demand ?</p><br>
                                                            <input type="hidden" name="id" id="id" value="">
                                                            <input type="hidden" name="user" id="user" value="">
                                                            <input type="hidden" name="step" value="response">
                                                            <input type="hidden" name="loan_type" value="{{ $loans->type }}"> <!-- Ajoutez ce champ -->
                                                            <input class="form-control" name="name" id="name" type="text" readonly>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" name="sendResponseAEmail" class="btn btn-success"><i class="fas fa-envelope"></i> Confirm and Send response</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>



                                        <!-- Modal pour refus -->

                                        <div class="modal" id="rejectModal">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Refuse demand</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{ route('loanDemand.store', ['id' => $loans->id]) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <p>What is the reasons for the rejection? ?</p>
                                                            <input type="hidden" name="id" id="id" value="">
                                                            <input type="hidden" name="user" id="user" value="">
                                                            <textarea class="form-control" name="reason" id="reason" type="text"></textarea>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" name="sendResponseREmail" class="btn btn-success"><i class="fas fa-envelope"></i> Confirm and Send response</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="tab-pane {{ request()->get('activeTab') === 'tab3' ? 'active' : '' }}" id="tab3">
                                        @can('process_loan')

                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 150px; margin-top: 30px;">
                                                Add Attachment
                                            </button>
                                        </div>
                                        @endcan

                                        <!-- <div class="table-responsive mt-15"> -->
                                        <!-- Votre contenu de tab2 ici -->
                                        @php
                                        $heads = [
                                        '#',
                                        'ID Loan',
                                        'name',
                                        'media',
                                        ['label' => 'Actions', 'no-export' => true, 'width' => 30],
                                        ];
                                        @endphp
                                        <!-- {{-- Minimal example / fill data using the component slot --}} -->
                                        <x-adminlte-datatable id="table1" :heads="$heads">
                                            @php
                                            $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                                                    <"row" <"col-12" tr> >
                                                        <"row" <"col-sm-12 d-flex justify-content-start" f> >';
                                                            $config['paging'] = false;
                                                            $config["lengthMenu"] = [ 10, 50, 100, 500];
                                                            @endphp
                                                            <?php $i = 0     ?>
                                                            @foreach($posts as $x)
                                                            <?php $i++ ?>
                                                            <tr>
                                                                <td>{{$i}}</td>

                                                                <td>{{ $loans->borrow_id}}</td>

                                                                <td>{{$x->name}}</td>

                                                                <td>
                                                                    @if ($x->hasMedia('files'))
                                                                    @php
                                                                    $media = $x->getFirstMedia('files');
                                                                    @endphp
                                                                    @if (strpos($media->mime_type, 'pdf') !== false)
                                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                                        <i class="fa fa-file-pdf"></i> {{ $media->name }}
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                                        <i class="fa fa-image"></i> {{ $media->name }}
                                                                    </a>
                                                                    @endif
                                                                    @elseif ($x->hasMedia('images'))
                                                                    @php
                                                                    $media = $x->getFirstMedia('images');
                                                                    @endphp
                                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                                        <i class="fa fa-image"></i> {{ $media->name }}
                                                                    </a>
                                                                    @else
                                                                    No media attached
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    <a href="{{ $media->getUrl() }}" target="_blank" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show">
                                                                        <i class="fa fa-lg fa-fw fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ $media->getUrl() }}" download class="btn btn-xs btn-default text-info mx-1 shadow" title="Download">
                                                                        <i class="fa fa-lg fa-fw fa-download"></i>
                                                                    </a>
                                                                    @can('process_loan')
                                                                    <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $x->id }}" data-name="{{ $x->name }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                        </x-adminlte-datatable>

                                        <!-- Add -->
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Add Attachment</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                                            <input type="hidden" name="loan_id" value="{{ $loans->id }}">

                                                            @foreach ($details as $detail)
                                                            <input type="hidden" name="loan_detail_id" id="loan_detail_id" value="{{ $detail->id }}">
                                                            @endforeach
                                                            {{ csrf_field() }}

                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Name :</label>
                                                                <input type="text" class="form-control" id="name" name="name">
                                                                <!-- <input type="hidden" name="borrow_id" value="{{ $loans->borrow_id }}"> -->

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">media:</label>
                                                                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,application/pdf">
                                                            </div>
                                                    </div>

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




                                        <!-- delete -->
                                        <div class="modal" id="modaldemo8">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Delete Post</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{ route('posts.destroy') }}" method="post">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <p>Etes-vous sûr de vouloir supprimer ce rayon ?</p><br>
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
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@stop
@section('js')

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


<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<script>
    $('#acceptModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var user = button.data('user');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #user').val(user);
    });
</script>

<script>
    $('#rejectModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        // var name = button.data('name');
        var user = button.data('user');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        // modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #user').val(user);
    });
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez l'élément <a> de l'onglet "tab3"
    const tab3Link = document.querySelector('a[href="#tab3"]');
    
    // Ajoutez un écouteur d'événements au bouton "Confirm and Send response"
    const confirmButton = document.querySelector('button[name="sendResponseAEmail"]');
    confirmButton.addEventListener('click', function () {
        // Activez l'onglet "tab3" lorsque le bouton est cliqué
        tab3Link.classList.remove('disabled');
    });
});

</script> -->


@stop