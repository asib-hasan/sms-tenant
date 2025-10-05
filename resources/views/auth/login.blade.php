<!DOCTYPE html>
<html lang="en">
<head>
	<title>My School</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('logins/images/icons/favicon.ico')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('logins/css/main.css')}}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<h4 style="width: 100%;padding-bottom:4rem;text-align:center;font-weight:bold">{{ $school_info->name }}</h4>
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset($school_info->logo_transparent) }}" alt="IMG">
				</div>
				@include('components.alert')
				<form action="{{ route('login') }}" class="form-prevent login100-form validate-form" method="GET">
					@csrf
					<span class="login100-form-title">Welcome</span>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="user_id" value="240026" placeholder="Username" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" value="12345678" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="container-login100-form-btn">
						<button type="submit" class="form-prevent-multiple-submit login100-form-btn">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="{{ asset('logins/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('logins/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('logins/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('logins/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})

        $('.form-prevent').on('submit', function () {

            $('.form-prevent-multiple-submit').attr('disabled', 'true');

            $('.form-prevent-multiple-submit').html('Processing...');

        });

	</script>
	<script src="{{ asset('logins/js/main.js')}}"></script>
</body>
</html>
