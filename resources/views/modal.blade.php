@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')






<!-- Structure du modal -->
<div class="modal fade" id="SendModal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alert, You must return the box!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
        </div>
    </div>
</div>
@endsection


@section('js')
<!-- JavaScript pour déclencher le modal -->
<script>
    $(document).ready(function() {
        $('#SendModal').modal('show');
    });
</script>
@stop
