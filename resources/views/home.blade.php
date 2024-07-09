@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

@can('structureArchiviste')
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
            <a href="boxArchived" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $siteCount }}</h3>
                <p>Rooms</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="sites" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $directionCount }}</h3>
                <p>Directions</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="directions" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $borrowedBoxesCount }}</h3>
                <p>Boxes Loaned</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <a href="boxLoaned" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endcan

@if(auth()->user()->hasRole('applicant'))

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $userDemandArchiveBoxesCount }}</h3>
                <p>Demand Archive Boxes</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $userArchiveDemandsCount }}</h3>
                <p> Accepted Demand Archive Boxes</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $userDemandLoanBoxesCount }}</h3>
                <p>Demand Loan Boxes</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $userLoanDemandsCount }}</h3>
                <p>Accepted Demand Loan Boxes</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-6">
        <h4 style="text-align: center;">Histogram of archive and loan demands per day</h4>
        <br>
        <canvas id="userDemandChart" height="100" width="100"></canvas>
    </div>

    <div class="col-lg-6">
        <h4 style="text-align: center;">Pie chart for accepted archive and loan demands</h4>
        <br>
        <canvas id="userAcceptedDemandsChart" height="100" width="100"></canvas>
    </div>
</div>
<br>
@endif

@can('structureArchiviste')
<br>
<div class="row">
    <div class="col-lg-6">
        <h4 style="text-align: center;">Histogram of archive and loan demands per day</h4>
        <br>
        <canvas id="loanDemandChart" height="100" width="100"></canvas>
    </div>
    <div class="col-lg-6">
        <h4 style="text-align: center;">Pie chart for archived, borrowed, overdue, and destroyed boxes</h4>
        <br>
        <canvas id="boxStatusChart" height="100" width="100"></canvas>
    </div>
</div>
<br>
@endcan

<div id="loanDemandData" data-loan-dates="{{ json_encode($loanDates) }}" data-loan-counts="{{ json_encode($loanCounts) }}" data-archive-dates="{{ json_encode($archiveDates) }}" data-archive-counts="{{ json_encode($archiveCounts) }}" data-boxes-archived="{{ $boxesArchivedCount }}" data-boxes-borrowed="{{ $borrowedBoxesCount }}" data-boxes-destroyed="{{ $destroyedBoxesCount }}" data-boxes-overdue="{{ $overdueBorrowedBoxesCount }}" data-user-loan-demands="{{ $userLoanDemandsCount }}" data-user-archive-demands="{{ $userArchiveDemandsCount }}" data-user-loan-dates="{{ json_encode($userLoanDates) }}" data-user-loan-counts="{{ json_encode($userLoanCounts) }}" data-user-archive-dates="{{ json_encode($userArchiveDates) }}" data-user-archive-counts="{{ json_encode($userArchiveCounts) }}" data-user-loan-demands="{{ $userLoanDemandsCount }}" data-user-archive-demands="{{ $userArchiveDemandsCount }}">
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loanDemandData = document.getElementById('loanDemandData');
        if (loanDemandData) {
            var loanDates = JSON.parse(loanDemandData.getAttribute('data-loan-dates'));
            var loanCounts = JSON.parse(loanDemandData.getAttribute('data-loan-counts'));
            var archiveDates = JSON.parse(loanDemandData.getAttribute('data-archive-dates'));
            var archiveCounts = JSON.parse(loanDemandData.getAttribute('data-archive-counts'));

            var ctx1 = document.getElementById('loanDemandChart');
            if (ctx1) {
                new Chart(ctx1.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: loanDates,
                        datasets: [{
                            label: 'Number of Loan Demands',
                            data: loanCounts,
                            // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            // borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Number of Archive Demands',
                            data: archiveCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
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
            }
            // Code for userAcceptedDemandsChart
            var userLoanDemandsCount = loanDemandData.getAttribute('data-user-loan-demands');
            var userArchiveDemandsCount = loanDemandData.getAttribute('data-user-archive-demands');

            var ctx4 = document.getElementById('userAcceptedDemandsChart');
            if (ctx4) {
                new Chart(ctx4.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Loan Demands Accepted', 'Archive Demands Accepted'],
                        datasets: [{
                            data: [userLoanDemandsCount, userArchiveDemandsCount],
                            backgroundColor: [
                                // 'rgba(54, 162, 235, 0.2)',
                                // 'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                // 'rgba(54, 162, 235, 1)',
                                // 'rgba(75, 192, 192, 1)'
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },

                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += context.parsed;
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            var boxesArchived = loanDemandData.getAttribute('data-boxes-archived');
            var boxesBorrowed = loanDemandData.getAttribute('data-boxes-borrowed');
            var boxesDestroyed = loanDemandData.getAttribute('data-boxes-destroyed');
            var boxesOverdue = loanDemandData.getAttribute('data-boxes-overdue');

            var ctx2 = document.getElementById('boxStatusChart');
            if (ctx2) {
                new Chart(ctx2.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Archived', 'Borrowed', 'Destroyed', 'Overdue Borrowed'],
                        datasets: [{
                            data: [boxesArchived, boxesBorrowed, boxesDestroyed, boxesOverdue],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.label || '';
                                        var value = context.raw;
                                        return label + ': ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            var userLoanDates = JSON.parse(loanDemandData.getAttribute('data-user-loan-dates'));
            var userLoanCounts = JSON.parse(loanDemandData.getAttribute('data-user-loan-counts'));
            var userArchiveDates = JSON.parse(loanDemandData.getAttribute('data-user-archive-dates'));
            var userArchiveCounts = JSON.parse(loanDemandData.getAttribute('data-user-archive-counts'));

            var ctx3 = document.getElementById('userDemandChart');
            if (ctx3) {
                new Chart(ctx3.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: userLoanDates,
                        datasets: [{
                            label: 'User Loan Demands',
                            data: userLoanCounts,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'User Archive Demands',
                            data: userArchiveCounts,
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
            }
        }

    });
</script>
@stop