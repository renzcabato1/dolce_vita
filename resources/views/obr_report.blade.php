@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >SOA History </a>
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
                        <label>Date :</label>
                        <select name='date_select' class='form-control'>
                            @foreach($date_uses as $date_use)
                            <option value='{{$date_use->date_soa}}' {{ ($date_use->date_soa == $date_select ? "selected":"") }}>{{date('M. Y', strtotime($date_use->date_soa))}}</option>
                            @endforeach
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
        @if($date_select != null)
         <a href='{{ url('/obr-report-pdf?date_select='.$date_select.'') }}' target='_' style='margin:5px;' class="btn btn-info"><i ></i>PRINT</a>
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="table-responsive">
                        <table  id='example' class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Billing Number</th>
                                    <th scope="col" style='width:100px'>Name</th>
                                    <th scope="col">Lot Number</th>
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
                                    $last_payment = $payments[$key];
                                    if($soa_payment->previos_interest <= 0)
            {
                $previous_interest = 0;
            }
            else
            {$previous_interest = $soa_payment->previos_interest;}
                                    $total_current_charges = ($soa_payment->special_assessment+$soa_payment->others+($soa_payment->rate * $soa_payment->lot_size));
                                    $total_overdue_charges = $soa_payment->previos_bill+$previous_interest-$soa_payment->discount-$last_payment;
                                    if(($soa_payment->previos_bill - $last_payment) <= 0)
                                    {
                                        $latest_interest = 0;
                                    }
                                    else
                                    {
                                        $latest_interest = ($soa_payment->previos_bill - $last_payment) *.02;
                                    }
                                    $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment;
                                    $total_amout_due = $sub_total + $total_current_charges;
                                    @endphp
                                    <td scope="col" style='width:100px'>{{$soa_number}}</td>
                                    <td scope="col" style='width:100px'> <span title='{{$soa_payment->client_name}}'>{{str_limit($soa_payment->client_name, 25)}}</span></td>
                                    <td scope="col">{{$soa_payment->client_lot_number}}</td>
                                    <td>₱ {{number_format($total_amout_due ,2)}}</td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" target='_'  href="{{ url('/soa-pdf/'.$soa_payment->id.'') }}">Print</a>
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
    </div>
</div>

@endsection
