@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $boxesArchivedCount }}</h3>
                <p>Boxes archived</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $demandArchiveBoxesCount }}</h3>
                <p>Demand archive Boxes</p>
            </div>
            <div class="icon">
                <i class="ion ion-document"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $demandLoanBoxesCount }}</h3>
                <p>Demand Loan Boxes</p>
            </div>
            <div class="icon">
                <i class="ion ion-chatboxes"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $borrowedBoxesCount }}</h3>
                <p>Boxes Loaned</p>
            </div>
            <div class="icon">
                <i class="ion ion-chatboxes"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Boxes Archived</h3>
            </div>
            <div class="card-body">
                <canvas id="boxesArchivedChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Demand Archive Boxes</h3>
            </div>
            <div class="card-body">
                <canvas id="demandArchiveBoxesChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var boxesArchivedCtx = document.getElementById('boxesArchivedChart').getContext('2d');
        var boxesArchivedChart = new Chart(boxesArchivedCtx, {
            type: 'bar',
            data: {
                labels: ['Archived Boxes'],
                datasets: [{
                    label: '# of Boxes Archived',
                    data: [{{ $boxesArchivedCount }}],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var demandArchiveBoxesCtx = document.getElementById('demandArchiveBoxesChart').getContext('2d');
        var demandArchiveBoxesChart = new Chart(demandArchiveBoxesCtx, {
            type: 'pie',
            data: {
                labels: ['Demand Archive Boxes', 'Others'],
                datasets: [{
                    label: '# of Demands',
                    data: [{{ $demandArchiveBoxesCount }}, 100 - {{ $demandArchiveBoxesCount }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    });
</script>
@endpush
<style>
    @font-face {
        font-family: 'Source Sans Pro';
        src: url('/fonts/SourceSansPro-Regular.woff2') format('woff2'),
             url('/fonts/SourceSansPro-Regular.woff') format('woff');
        font-weight: normal;
        font-style: normal;
    }
</style>

@stop
