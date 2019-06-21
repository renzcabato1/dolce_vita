@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >Ledger Report </a>
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
                <style>
                    #name_chosen{
                        width: 100% !important;
                        color:black;
                    }
                    .chosen-search-input
                    {
                        width: 100% !important; 
                    }
                </style>
                <div class='col-md-8'>
                    <div class="form-group">
                        <label>Name:</label>
                        <select class="chosen-select form-control"  style='height:50px;color:black' name='name' id='name'  required >
                            <option></option>
                            @foreach($clients as $client)
                            <option value='{{$client->id}}'  {{ ($client->id == $client_id ? "selected":"") }}>{{$client->name}}</option>
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
        @if($client_id != null)
        <br>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" border='1'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan='12' style='width:100px'>
                                        Name : {{$cl->name}}<br>
                                        Area : {{$cl->area}}<br>
                                        Cost : 7<br>
                                        Hoa ID : {{$cl->hoa_id}}<br>
                                        Ph-Blk-Lot : {{$cl->lot_number}}<br>
                                        Dues start date : {{date('M. Y',strtotime($cl->start_month))}}<br>
                                    </th>
                                </tr>
                                <tr  align='center'>
                                    <th scope="col" rowspan='2' style='width:100px'>Applicable Month</th>
                                    <th scope="col" colspan='3'>Beginning Balance</th>
                                    <th scope="col" rowspan='2'>Monthly Dues</th>
                                    <th scope="col" rowspan='2'>Payment</th>
                                    <th scope="col" rowspan='2'>Montly Interest</th>
                                    <th scope="col" rowspan = 2>Principal Adjustment</th>
                                    <th scope="col" rowspan = 2>Interest Adjustment:</th>
                                    <th scope="col" colspan='3'>Ending Balance</th>
                                    
                                </tr>
                                <tr  align='center'>
                                    <th scope="col">Principal</th>
                                    <th scope="col">Interest</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Principal</th>
                                    <th scope="col">Interest</th>
                                    <th scope="col">Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $ending_principal = 0;
                                $ending_interest = 0;
                                $ending_total = 0;
                                @endphp
                                @foreach($soapayment as $key => $soa)
                                <tr>
                                    <td>{{date('M. Y',strtotime($soa->date_due))}}
                                    </td>
                                    @if($key == 0)
                                    @php
                                        $ending_principal = $soa->previos_bill;
                                        $ending_interest = $soa->previos_interest;
                                        $ending_total = $soa->previos_bill+$soa->previos_interest
                                    @endphp
                                     <td>
                                        {{number_format($ending_principal,2)}}
                                    </td>
                                    <td>
                                        {{number_format($ending_interest,2)}}
                                    </td>
                                    <td>
                                        {{number_format($ending_total,2)}}
                                    </td>
                                    @else
                                    <td>
                                        {{number_format($ending_principal,2)}}
                                    </td>
                                    <td>
                                        {{number_format($ending_interest,2)}}
                                    </td>
                                    <td>
                                        {{number_format($ending_total,2)}}
                                    </td>
                                    @endif
                                    
                                    <td>
                                        {{number_format(7*$cl->area,2)}}
                                    </td>
                                    <td>
                                        {{number_format(($data[$key]['payment']),2)}}
                                    </td>
                                    <td>
                                        @php
                                        $rate_interest = $ending_principal-$data[$key]['payment'];
                                        if($rate_interest <= 0)
                                        {
                                            $interest_rate = 0;
                                        }
                                        else 
                                        {
                                            $interest_rate =  $rate_interest * .02;
                                        }
                                        @endphp
                                        {{number_format($interest_rate,2)}}
                                    </td>
                                    <td>
                                        {{number_format($soa->discount,2)}}
                                    </td>
                                    <td>
                                        {{number_format($soa->adjustment,2)}}
                                    </td>
                                    <td>
                                        @php
                                        $principal = $ending_principal + (7*$cl->area) - $soa->discount - $data[$key]['payment'];
                                        $ending_principal = $principal;
                                        @endphp
                                        {{number_format($principal,2)}}
                                    </td>
                                    <td>
                                        @php
                                        $total_interest = $ending_interest + $interest_rate - $soa->adjustment ;
                                        $total_ending_balance = $total_interest +  $principal;
                                        $ending_interest =  $total_interest;
                                        $ending_total = $total_ending_balance ;
                                        @endphp
                                        {{number_format($total_interest,2)}}
                                    </td>
                                    <td>
                                        {{number_format($total_ending_balance,2)}}
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
