<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" type="image/png" href="{{ asset('/images/icon.png')}}"/>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'Laravel') }}</title>
  
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('navbar/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
  <link href="{{ asset('navbar/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('chosen/chosen.css') }}">
  <!-- Argon CSS -->
  <link type="text/css" href="navbar/css/argon.css?v=1.0.0" rel="stylesheet">
  
  <style>
    
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url("{{ asset('/images/3.gif')}}") 50% 50% no-repeat rgb(249,249,249) ;
      opacity: .8;
      background-size:120px 120px;
    }  
    #example_length{
      padding-top: 20px;
      padding-left:20px;
    }
    #example_filter
    {
      padding-top: 20px;
      text-align:right;
      padding-right: 20px;
    }
    #example_info
    {
      padding-left:20px;
    }
    #example_paginate
    {
      float:right;
      padding-right: 20px;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    .error
    {
      color:red;
      font-size: 10px;
    }
    @media (min-width: 768px) {
      .modal-xl {
        width: 90%;
        max-width:1200px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidenav -->
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="./index.html">
        <img src="{{ asset('navbar/img/brand/blue.png')}}" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="{{ asset('navbar/img/theme/team-1-800x800.jpg')}}">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Activity</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./index.html">
                <img src="{{ asset('navbar/img/brand/blue.png')}}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}" onclick='show()'>
              <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/soa') }}" onclick='show()'>
              <i class="ni ni-money-coins text-blue"></i> SOA
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/ca-receipt') }}" onclick='show()'>
              <i class="ni ni-check-bold text-yellow"></i> CA Receipt
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/hmo') }}" onclick='show()'>
              <i class="ni  text-red fas fa-users"></i> HOA
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/user-accounts') }}" onclick='show()'>
              <i class="ni ni-circle-08 text-info"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/summary-report') }}" onclick='show()'>
              <i class="ni ni-chart-bar-32 text-orange"></i>Summary Report
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/obr-report') }}" onclick='show()'>
              <i class="ni ni-chart-bar-32 text-orange"></i>SOA History
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/payment') }}" onclick='show()'>
              <i class="ni ni-money-coins text-infor"></i>Payment
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/ledger?name=1') }}" onclick='show()'>
              <i class="ni ni-money-coins text-infor"></i>Ledger
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/disbursement') }}" onclick='show()'>
              <i class="ni ni-money-coins text-infor"></i>Disbursement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/disbursement-report-a') }}" onclick='show()'>
              <i class="ni ni-money-coins text-infor"></i>Disbursement Report
            </a>
          </li>
          
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
      </div>
    </div>
  </nav>
  @yield('content')
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('navbar/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('navbar/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
  <script src="{{ asset('jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dataTables.bootstrap4.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('navbar/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('navbar/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('navbar/js/argon.js?v=1.0.0') }}"></script>
  
  <div id = "myDiv" style="display:none;" class="loader">
  </div>
  
  <script src="{{ asset('/chosen/chosen.jquery.js')}}" type="text/javascript"></script>
  <script src="{{ asset('/chosen/docsupport/init.js')}}" type="text/javascript" charset="utf-8"></script> 
  
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    } );
    $(document).ready(function() {
      $('#example1').DataTable();
    } );
    $(document).ready(function() {
      $('#example2').DataTable();
    } );
    function show() {
      document.getElementById("myDiv").style.display="block";
    }
    function logout(){
      event.preventDefault();
      document.getElementById('logout-form').submit();
    }
    var check = function() {
      if (document.getElementById('password').value ==
      document.getElementById('confirm_password').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'Match';
        document.getElementById('submit').disabled = false;
      } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Not Match';
        document.getElementById('submit').disabled = true;
      }
    }
    var check1 = function() {
      if (document.getElementById('password1').value ==
      document.getElementById('password2').value) {
        document.getElementById('message1').style.color = 'green';
        document.getElementById('message1').innerHTML = 'Match';
        document.getElementById('submit1').disabled = false;
      } else {
        document.getElementById('message1').style.color = 'red';
        document.getElementById('message1').innerHTML = 'Not Match';
        document.getElementById('submit1').disabled = true;
      }
    }
  </script>
  
</body>
</html>
