@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >SOA ({{$name_of_month}})</a>
                <button data-toggle="modal" data-target="#generate_soa" data-toggle="generate_soa"  type="button" style='margin:5px;' class="btn btn-success"><i ></i>GENERATE SOA</button>
                
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
                        <table>
                            <tr>
                                <form action='print-soa-pdf' method='get' target='_'>
                                    <td>
                                        <select name='type' class='form-control' style='widht:100px;' required>
                                            <option value='1'>All</option>
                                            <option value='2'>Resident</option>
                                            <option value='3'>Non-Resident</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type='submit'  style='margin:5px;' class="btn btn-info"><i ></i>PRINT</button>
                                    </td>
                                </form>
                            </tr>
                            <table>
                                <table id="example" class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Billing Number</th>
                                            <th scope="col" style='width:100px'>Name</th>
                                            <th scope="col">Lot Number</th>
                                            <th scope="col">HOA ID</th>
                                            <th scope="col">Total Amount(OBR)</th>
                                            <th scope="col">Payment</th>
                                            <th scope="col">Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($soa_payments as $key => $soa_payment)
                                        <tr>
                                            @php
                                            if(($soa_payment->billing_number/10) < 1 )
                                            {
                                                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-00'.$soa_payment->billing_number;
                                            }
                                            else if(($soa_payment->billing_number/10) < 10 )
                                            {
                                                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-0'.$soa_payment->billing_number;
                                            }
                                            else 
                                            {
                                                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-'.$soa_payment->billing_number;
                                            }
                                            @endphp
                                            <td scope="col" style='width:100px'>{{$soa_number}}</td>
                                            <td scope="col" style='width:100px'> <span title='{{$soa_payment->client_name}}'>{{str_limit($soa_payment->client_name, 25)}}</span></td>
                                            <td scope="col">{{$soa_payment->client_lot_number}}</td>
                                            <td scope="col">{{$soa_payment->client_hoa_id}}</td>
                                            <td scope="col">{{number_format(($data[$key]['total_amout_due']),2)}}</td>
                                            <td scope="col">{{number_format(($data[$key]['payment']),2)}}</td>
                                            <td scope="col">{{number_format(($data[$key]['soa_summary']),2)}}</td>
                                            <td class="text-left">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                       
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#edit_soa{{$soa_payment->id}}" data-toggle="edit"  href="#">Edit</a>
                                                        <a class="dropdown-item" target='_'  href="{{ url('/soa-pdf/'.$soa_payment->id.'') }}">Print</a>
                                                    </div>
                                                </div>
                                                @include('edit_payment')
                                                @include('edit_soa')
                                                @include('add_payment')
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
        @include('generate_soa')
        @endsection
        