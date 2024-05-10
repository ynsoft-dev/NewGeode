@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Loan Request Details</h1>
<!-- <div class="text-center">

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Loan Requests lists</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Loan Requests Details</span>
            </div>
        </div>
    </div>
</div> -->

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
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">
                                                Loan Request Details</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab4">
                                        <div class="table-responsive mt-15">

                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr>
                                                      
                                                        <th scope="row"> Box name</th>
                                                        <td>{{ $loans->box_name }}</td>
                                                        <th scope="row"> Kind of loan</th>
                                                        <td>{{ $loans->kind }}</td>
                                                        <th scope="row"> request date</th>
                                                        <td>{{ $loans->request_date }}</td>
                                                        <th scope="row"> Return date</th>
                                                        <td>{{ $loans->return_date }}</td>
                                                        



                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Membership</th>
                                                        <td>{{ $loans->Membership }}</td>
                                                        <th scope="row">Direction</th>
                                                        <td>{{ $loans->Direction->name }}</td>
                                                        <th scope="row">Departement</th>
                                                        <td>{{ $loans->department->name }}</td>
                                                        <th scope="row">Status</th>

                                                            @if ($loans->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $loans->Status }}</span>
                                                                </td>
                                                            @elseif($loans->Value_Status ==2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $loans->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $loans->Status }}</span>
                                                                </td>
                                                            @endif

                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /div -->
    </div>

</div>


</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@stop
@section('js')




<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

@endsection