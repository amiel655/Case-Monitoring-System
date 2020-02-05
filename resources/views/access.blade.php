@extends('layouts.app')

@section('content')
<div class="main-div home-page">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light home-nav justify-content-between">
            <a class="navbar-brand"></a>
            <div class="mr-sm-2">
                <a class="nav-link" href="/login">LOGIN</a>
            </div>
        </nav>
        <div class="case-cont">
            <div class="case-sum">
                CASE SUMMARY
            </div>

            <div class="pt-3">
                @if($data[0]->case_summary !== null)
                <div class="alert alert-primary" role="alert">
                    Next Hearing Date: <span>{{date('M-d-Y', strtotime($data[0]->hearing_date))}}</span>
                </div>@endif

                @foreach($data as $results)
                <div class="card card-summary">
                    @if($results->case_status === 'Pending')
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">{{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    @if($results->case_status === 'Arraignment')
                    <div class="card-header bg-primary">
                        <div class="row">
                            <div class="col-md-6">{{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    @if($results->case_status === 'Pre-Trial')
                    <div class="card-header bg-secondary">
                        <div class="row">
                            <div class="col-md-6">{{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    @if($results->case_status === 'Prosecution Evidence')
                    <div class="card-header bg-warning">
                        <div class="row">
                            <div class="col-md-6">{{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    @if($results->case_status === 'Defense Evidence')
                    <div class="card-header bg-info">
                        <div class="row">
                            <div class="col-md-6">{{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    @if($results->case_status !== 'Pending' && $results->case_status !== 'Arraignment' &&
                    $results->case_status !== 'Pre-Trial' && $results->case_status !== 'Prosecution Evidence' &&
                    $results->case_status !== 'Defense Evidence')
                    <div class="card-header bg-danger">
                        <div class="row">
                            <div class="col-md-6">Terminated: {{$results->case_status }}
                            </div>
                            <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                    date('M-d-Y', strtotime($results->hearing_date)) }}</span></div>
                        </div>
                    </div>
                    @endif
                    <div class="card-body">
                        @if($results->case_summary !== null)
                        <div class="summary">
                            {{$results->case_summary}}
                        </div>
                        @endif
                        @if($results->case_summary === null)
                        <p class="card-text">No Summary</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div><br>
        </div>
    </div>
    @endsection
    <script>
        window.setTimeout(() => {
            let count = document.querySelectorAll('.summary').length
            for (let i = 0; i < count; i++) {
                document.querySelectorAll('.summary')[i].innerHTML = document.querySelectorAll('.summary')[i].innerText
            }
        })

    </script>
