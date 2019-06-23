@extends('layouts.app_navbar')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" >Disbursement Report </a>
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
                        <label>Account Number:</label>
                        <select class="form-control" name='check_type' required>
                            <option></option>
                            <option value='AUB CA 101-01-000245-7' {{ ($type == 'AUB CA 101-01-000245-7' ? "selected":"") }} >AUB CA 101-01-000245-7</option>
                            <option value='AUB CA 101-01-000294-2' {{ ($type == 'AUB CA 101-01-000294-2' ? "selected":"") }} >AUB CA 101-01-000294-2</option>
                            
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
        <a href='{{ url('/disbursement-report-a-b?date_from='.$date_from.'&date_to='.$date_to.'&check_type='.$type) }}' target='_' style='margin:5px;' class="btn btn-info"><i ></i>PRINT</a>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="table-responsive">
                        <table  id='example' class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style='width:100px'>Payee</th>
                                    <th scope="col">Check Date</th>
                                    <th scope="col">Particulars</th>
                                    <th scope="col">CV Number</th>
                                    <th scope="col">RPLF Number</th>
                                    <th scope="col">Check Number</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Amunt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ca_receipts as $ca_receipt)
                                <tr>
                                    <td style='min-width:100px' >
                                        <span title='{{$ca_receipt->payee}}'>{{str_limit($ca_receipt->payee, 25)}}</span>
                                    </td>
                                    <td style='min-width:100px' >
                                        {{date('M. d, Y', strtotime($ca_receipt->check_date))}}
                                        
                                    </td>
                                    <td style='min-width:100px' >
                                        {{$ca_receipt->particulars}}
                                    </td>
                                    <td style='min-width:100px' >
                                        {{$ca_receipt->cv_number}}
                                    </td>
                                    <td style='min-width:100px' >
                                        {{$ca_receipt->rplf_number}}
                                    </td>
                                    <td style='min-width:100px' >
                                        {{$ca_receipt->check_number}}
                                    </td>
                                    <td style='min-width:100px' >
                                        {{$ca_receipt->reference}}
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
        
        @endif
    </div>
</div>

@endsection
