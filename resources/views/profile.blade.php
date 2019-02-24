@extends('layouts.app_navbar')
@section('content')
 <!-- Main content -->
 <div class="main-content">
  <!-- Top navbar -->
  <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">User profile</a>
    
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
  <!-- Header -->
  
  <div class="header pb-8 pt-5  d-flex align-items-center" 
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    
  </div>
  <!-- Page content -->
  <div class="container-fluid mt--7">
    <div class="row">
     
      <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
          <div class="card-header bg-white border-0">
            <div class="row align-items-center">
                @if(session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong>Success!</strong> {{session()->get('status')}}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
              <div class="col-8">
                <h3 class="mb-0">My account</h3>
              </div>
              <div class="col-4 text-right">
                <a data-toggle="modal" data-target="#profile" data-toggle="profle" style='color:white;' class="btn btn-sm btn-primary">Change Password</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form>
              <h6 class="heading-small text-muted mb-4">User information</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Name</label>
                      <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Name" value="{{Auth::user()->name}}" readonly>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-email">Email address</label>
                      <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="{{Auth::user()->email}}" readonly>
                    </div>
                  </div>
                </div>
              </div>
            
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
         
          <form  method='POST' action='change-password'  onsubmit="show()" >
              <div class="modal-body">
                  {{ csrf_field() }}
               
                  <label style="position:relative; top:7px;">New Password:</label>
                  <input type='password'  class="form-control" pattern=".{8,}"  name='password' id='password'  onkeyup='check();' required>
                  
                  <p style="font-size:10px;color:red">Passwords must be at least 8 characters long.</p>
                  
                  <label style="position:relative; top:7px;"> Confirm Password :</label>
                  <input type='password'  class="form-control"  pattern=".{8,}" name='password_confirmation'  onkeyup='check();' id='confirm_password'  required>
                  <p style="font-size:10px;" id='message'></p>
              </div>
              
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id='submit' class="btn btn-primary" >Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection
