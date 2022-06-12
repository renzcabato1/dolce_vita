@extends('layouts.app')
@section('content')
    <div class="limiter">
		<div class="container-login100" style="background-image: url('{{ asset('images/background.png')}}');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					{{ config('app.name', 'Laravel') }}
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="POST" action="{{ route('login') }}" onsubmit='show()'>
                    @csrf
					<div class="wrap-input100 validate-input">
						<input class="input100" type="email" name="email" placeholder="Email" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button type='submit' class="login100-form-btn">
							Login
						</button>
                    </div>
                   
                    <div class="container-login100-form-btn m-t-32">
                            @if ($errors->has('email'))
                            <span class="help-block" style="color:red;align:center" align='center'>
                                <strong style='color:red;'>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                            @if ($errors->has('password'))
                            <span class="help-block" style="color:red;align:center" align='center'>
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            @if(session()->has('status'))
                            <span class="help-block" style="color:red;align:center" align='center'>
                                <strong>{{ session()->get('status')}}</strong>
                            </span>
                            @endif
                    </div>
				</form>
			</div>
		</div>
	</div>
@endsection
