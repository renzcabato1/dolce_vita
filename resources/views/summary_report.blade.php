@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >Summary Report </a>
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
        <form  method="GET" action="" onsubmit= "show()">
            <div class="row shadow col" style='background-color:gray;border-radius:15px;color:white;'>
                <div class='col-md-3'>
                    <div class="form-group">
                        <label>Date From:</label>
                    <input class="form-control"  value='{{$date_from}}' type="date" name='date_from'  required >
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-group">
                        <label>Date To:</label>
                        <input class="form-control" value='{{$date_to}}'  type="date" name='date_to'  required >
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-group">
                        <label>Type:</label>
                        <select class="form-control" name='type' required>
                            <option></option>
                            <option value='1' {{ ($type == '1' ? "selected":"") }} >Payment Report</option>
                            <option value='2' {{ ($type == '2' ? "selected":"") }}>CA Receipt History</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-info btn-fill">Generate</button>
                    </div>
                </div>
            </div>
        </form>
        @if($type != null)
        @if($type == 1)
        <a href='{{ url('/payment-report?date_from='.$date_from.'&date_to='.$date_to) }}' target='_' style='margin:5px;' class="btn btn-info"><i ></i>PRINT</a>
        <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="table-responsive">
                            <table  id='example' class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style='width:100px'>Client Name</th>
                                        <th scope="col">Lot Number</th>
                                        <th scope="col">Date Paid</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ca_receipts as $ca_receipt)
                                    <tr>
                                        <td style='min-width:100px' >
                                            <span title='{{$ca_receipt->client_name}}'>{{str_limit($ca_receipt->client_name, 25)}}</span>
                                        </td>
                                        <td style='min-width:100px' >
                                            {{$ca_receipt->lot_number}}
                                        </td>
                                        <td scope="col">
                                            {{date('M. d, Y', strtotime($ca_receipt->date_paid))}}
                                        </td>
                                        <td style='min-width:100px' >
                                            {{$ca_receipt->type}}
                                        </td>
                                        <td scope="col">
                                        ₱ {{number_format($ca_receipt->amount,2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <a href='{{ url('/ca-report?date_from='.$date_from.'&date_to='.$date_to) }}' target='_' style='margin:5px;' class="btn btn-info"><i ></i>PRINT</a>
        <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="table-responsive">
                            <table id='example'  class="table align-items-center table-flush">
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
                                                <a class="dropdown-item" target='_'  href="{{ url('/car-pdf/'.$ca_receipt->id.'') }}">Print</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endif
    </div>
</div>

@endsection
