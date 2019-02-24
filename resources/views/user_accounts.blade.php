@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >Users</a>
                <button data-toggle="modal" data-target="#new_user" data-toggle="new_user"  type="button" style='margin:5px;' class="btn btn-success"><i class="ni ni-fat-add"></i>Add User</button>
                
            </span>
            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ asset('images/no-image.jpeg')}}">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{Auth()->user()->name}}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="{{ url('/profile') }}" onclick="show();" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"  onclick="logout(); show();" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                        @if(Auth::user())
                        <form id="logout-form"  action="{{ route('logout') }}"  method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="header bg-gradient-primary pb-5 pt-5 pt-md-8">
        
    </div>
    <div class="container-fluid mt--7">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="table-responsive">
                        @if(session()->has('status'))
                        <div class="alert alert-success alert-dismissible fade show " role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-inner--text"><strong>Success!</strong> {{session()->get('status')}}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @include('error')
                        <table id='example' class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style='width:100px'>Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="col" style='width:100px'>{{$user->name}}</th>
                                        <th scope="col">{{$user->email}}</th>
                                        <th scope="col"></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('new_user')
@endsection
