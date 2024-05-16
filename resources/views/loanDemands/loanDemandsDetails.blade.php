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
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Loan Demand's Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Loan Demand Response</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Loan Attachment</a>
                                        </li>
                                    </ul>


                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="table-responsive mt-15">

                                            <table class="table table-striped" style="text-align:center">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">ID Loan:</th>
                                                        <th scope="row"> Type of loan:</th>
                                                        <th scope="row"> Request date:</th>
                                                        <th scope="row"> Return date:</th>
                                                        <th scope="row">Direction:</th>
                                                        <th scope="row">Departement:</th>
                                                        <th scope="row">Demand Details:</th>
                                                        <th scope="row">User:</th>
                                                        <th scope="row">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $loans->borrow_id}}</td>
                                                        <td>{{ $loans->type }}</td>
                                                        <td>{{ $loans->request_date }}</td>
                                                        <td>{{ $loans->return_date }}</td>
                                                        <td>{{ $loans->Direction->name }}</td>
                                                        <td>{{ $loans->department->name }}</td>
                                                        <td>{{ $loans->box_name }}</td>
                                                        @foreach($details as $detail)
                                                        <td>{{ $detail->user}}</td>
                                                        @endforeach
                                                        @if ($loans->Value_Status == 1)
                                                        <td><span class="badge badge-pill badge-success">{{ $loans->Status }}</span>
                                                        </td>
                                                        @elseif($loans->Value_Status ==2)
                                                        <td><span class="badge badge-pill badge-danger">{{ $loans->Status }}</span>
                                                        </td>
                                                        @else
                                                        <td><span class="badge badge-pill badge-warning">{{ $loans->Status }}</span>
                                                        </td>
                                                        @endif

                                                    </tr>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <form action="{{ route('process_loan') }}" method="post">
                                            @csrf
                                            <div id="rejection_reason_field" style="display: none;">
                                                <div class="form-group">
                                                    <label for="rejection_reason">Motif de refus :</label>
                                                    <input type="text" class="form-control" id="rejection_reason" name="rejection_reason">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success" name="action" value="accept">Accepter</button>
                                            <button type="submit" class="btn btn-danger" name="action" value="reject">Refuser</button>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="tab3">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="width: 150px; margin-top: 30px;">
                                                Add Attachment
                                            </button>
                                        </div>

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
                                                                    <a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-effect="effect-scale" data-id="{{ $x->id }}" data-name="{{ $x->name }}" data-toggle="modal" href="#modaldemo8"><i class="fa fa-lg fa-fw fa-trash"></i></a>
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
                                                    <form action="posts/destroy" method="post">
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
    $(document).ready(function() {
        // Vérifie si la variable activeTab existe dans la session
        var activeTab = '{{ session("activeTab") }}';
        if (activeTab === 'tab3') {
            // Active l'onglet Tab2
            $('a[href="#tab3"]').tab('show');
        }
    });
</script>


<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<script>
   // Gestion du clic sur le bouton "Accepter"
$('button[value="accept"]').click(function(event) {
    // Empêcher le comportement par défaut du formulaire
    event.preventDefault();
    
    // Afficher le bouton "Add Attachment" dans l'onglet "Loan Attachment" (tab3) après un court délai
    setTimeout(function() {
        $('a[href="#tab3"]').tab('show');
    }, 100); // Changer la valeur de délai si nécessaire
});
</script>


@endsection