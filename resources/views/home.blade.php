@extends('layouts.app')

@section('content')
<div class=" home-page">
    <div class="container-fluid">
<nav class="navbar navbar-light bg-light home-nav justify-content-between">
  <a class="navbar-brand"></a>
   <div class="mr-sm-2">
     <a class="nav-link" href="/login" class="login-btn">LOGIN</a>
   </div>
</nav>
        <div class="row justify-content-center pt-5 pb-2">
            <div class="col-md-12 text-center pt-5 locale">
                <img src="./img/logo/PAO_Logo.png" alt="PAO's Logo" class="img-fluid login-logo">
                <h1>Public Attorney's Office</h1>
                <h3>San Fernando District</h3>
            </div>
            <div class="col-md-4"></div>
        <div class="col-md-4">
             {!! Form::open(['action' => 'CaseController@index','method' => 'POST']) !!}
            <div class="form-group">

                {{Form::text('access_code', '',['required', 'placeholder' => 'Enter Access Code', 'class' => 'form-control access-code-input'])}}
            </div>
            <div class="text-center">
                {{Form::submit('Search Case', ['class'=>'btn btn-success btn-lg btn-search-case'])}}
            </div>
            <div class="padding"></div>
{!! Form::close() !!}
        </div>
        <div class="col-md-4"></div>
        <div class="pb-5 mb-5"></div>


    </div>
    </div>
</div>
@endsection
