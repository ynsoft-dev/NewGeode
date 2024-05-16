@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@can('notifications')
<x-adminlte-card title="Notifications" theme="info" icon="fas fa-lg fa-bell" collapsible removable maximizable>

    <div class="menu-header-content" style="padding: 10px; border-radius: 5px;">
        <div class="d-flex align-items-center justify-content-between">
            <button class="btn btn-primary">
                <a href="\MarkAsRead_all" class="text-white">Read All</a>
            </button>
            <p class="mb-0 dropdown-title-text subtext text-blue op-6 tx-12" style="color: blue;">
                <span class="font-weight-bold" id="notifications_count">
                Number of unread Notifications: {{ auth()->user()->unreadNotifications->count() }} </span>
            </p>
        </div>
    </div>
    <div id="unreadNotifications">
        @foreach (auth()->user()->unreadNotifications as $notification)
        <div class="main-notification-list Notification-scroll">
            <a class="d-flex p-3 border-bottom" href="{{ url('loanDetails') }}/{{ $notification->data['id'] }}">
                <div class="notifyimg bg-pink">
                    <i class="la la-file-alt text-white"></i>
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <div class="mr-3">
                                <h5 class="notification-label mb-1">
                                    {{ $notification->data['borrow'] }}
                                </h5>
                                <div class="notification-subtext">{{ $notification->created_at }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right mb-3">
                                <div class="mr-3">
                                    <h5 class="notification-label mb-1">
                                        {{ $notification->data['user'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
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