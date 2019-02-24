@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >CA Receipt</a>
                <button data-toggle="modal" data-target="#new_car" data-toggle="new_car"  type="button" style='margin:5px;' class="btn btn-success"><i class="ni ni-fat-add"></i>Add CAR</button>
                
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
                        <table   class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style='width:100px'>CA Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Ammount</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ca_receipts as $ca_receipt)
                                <tr>
                                    <td scope="col">
                                        @php
                                            if(($ca_receipt->ca_number/10) < 1 )
                                            {
                                                $car_number = date('Y-m',(strtotime($ca_receipt->created_at))).'-00'.$ca_receipt->ca_number;
                                            }
                                            else if(($ca_receipt->ca_number/10) < 10 )
                                            {
                                                $car_number = date('Y-m',(strtotime($ca_receipt->created_at))).'-0'.$ca_receipt->ca_number;
                                            }
                                            else 
                                            {
                                                $car_number = date('Y-m',(strtotime($ca_receipt->created_at))).'-'.$ca_receipt->ca_number;
                                            }
                                        @endphp
                                        {{$car_number}}
                                    </td>
                                    <th style='min-width:100px' >
                                        <span title='{{$ca_receipt->name}}'>{{str_limit($ca_receipt->name, 25)}}</span>
                                    </th>
                                    <td scope="col">
                                        {{date('M. d, Y', strtotime($ca_receipt->date))}}
                                    </td>
                                    <td scope="col">
                                    ₱ {{number_format($ca_receipt->amount,2)}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#edit_car{{$ca_receipt->id}}" data-toggle="new_hmo"  href="#">Edit</a>
                                            <a class="dropdown-item" target='_'  href="{{ url('/car-pdf/'.$ca_receipt->id.'') }}">Print</a>
                                            </div>
                                            
                                        </div>
                                        @include('edit_car')
                                    </td>
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
@include('new_car')
@endsection
