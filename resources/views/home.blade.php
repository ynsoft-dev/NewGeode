@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@can('notifications')
<x-adminlte-card title="Notifications" theme="info" icon="fas fa-lg fa-bell" collapsible removable maximizable>

    <div class="menu-header-content bg-primary text-right">
        <div class="d-flex">
            <span class="badge badge-pill badge-warning mr-auto my-auto float-left"><a href="\MarkAsRead_all">Read All </a></span>
        </div>
        <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
        <h6 style="color: yellow" id="notifications_count">
            <!-- pour afficher nbr de notification non lue  -->
            nombre de notification non lue: {{ auth()->user()->unreadNotifications->count() }}
        </h6>
        </p>
    </div>
    <div id="unreadNotifications">
        @foreach (auth()->user()->unreadNotifications as $notification)
        <div class="main-notification-list Notification-scroll">
            <a class="d-flex p-3 border-bottom" href="{{ url('loanDetails') }}/{{ $notification->data['id'] }}">
                <div class="notifyimg bg-pink">
                    <i class="la la-file-alt text-white"></i>
                </div>
                <div class="mr-3">
                    <h5 class="notification-label mb-1">{{ $notification->data['title'] }}
                        {{ $notification->data['user'] }}
                    </h5>
                    <div class="notification-subtext">{{ $notification->created_at }}</div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
    </div>

</x-adminlte-card>
@endcan
@stop

@section('content')
<!-- <p>Welcome to this beautiful admin panel.</p> -->

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>

<script>
    setInterval(function() {
        $("#notifications_count").load(window.location.href + " #notifications_count");
        $("#unreadNotifications").load(window.location.href + " #unreadNotifications");
    }, 5000);

</script>
@stop