@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @can('notifications')
        <x-adminlte-card title="Notifications" theme="info" icon="fas fa-lg fa-bell" collapsible removable maximizable>
            <div class="menu-header-content" style="padding: 10px; border-radius: 5px;">
                <div class="d-flex align-items-center justify-content-between">
                    <button class="btn btn-primary" id="read-all-btn">
                        <a href="{{ route('notifications.markAsReadAll') }}" class="text-white">Read All</a>
                    </button>
                    <p class="mb-0 dropdown-title-text subtext text-blue op-6 tx-12" style="color: blue;">
                        <span class="font-weight-bold" id="notifications_count">
                            Number of unread Notifications: {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </p>
                </div>
            </div>
            <div id="unreadNotifications">
                <!-- Notification items will be loaded dynamically here -->
            </div>
        </x-adminlte-card>
    @endcan
@stop

@section('content')

@stop

@section('js')
    <script>
        function fetchNotifications() {
            $.ajax({
                url: '{{ route("notifications.get") }}',
                method: 'GET',
                success: function(data) {
                    $('#notifications_count').html('Number of unread Notifications: ' + data.label);
                    $('#unreadNotifications').html(data.dropdown);
                }
            });
        }

        $(document).ready(function() {
            fetchNotifications();

            $(document).on('click', '#read-all-btn', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    method: 'GET',
                    success: function(data) {
                        fetchNotifications();
                    }
                });
            });

            $(document).on('click', '#unreadNotifications .dropdown-item', function(e) {
                var url = $(this).attr('href');
                e.preventDefault();
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        fetchNotifications();
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
@stop
