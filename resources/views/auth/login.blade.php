
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities." />
        <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app" />
        <meta name="author" content="pixelstrap" />
        <link rel="icon" href="{{ asset('template_dashboard/assets/images/favicon.png') }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('template_dashboard/assets/images/favicon.png') }}" type="image/x-icon" />
        <title>LOGIN
</title>
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet" />
<!-- Font Awesome-->
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/fontawesome.css') }}" />
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/icofont.css') }}" />
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/themify.css') }}" />
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/flag-icon.css') }}" />
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/feather-icon.css') }}" />
<!-- Plugins css start-->
<!-- Plugins css Ends-->
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/bootstrap.css') }}" />
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/style.css') }}" />


<link id="color" rel="stylesheet" href="{{ asset('template_dashboard/assets/css/color-1.css') }}" media="screen" />
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{ asset('template_dashboard/assets/css/responsive.css') }}" />
    </head>
    <body>
        <!-- Loader starts-->
        <div class="loader-wrapper">
            <div class="theme-loader">
                <div class="loader-p"></div>
            </div>
        </div>
        <!-- Loader ends-->
        <!-- error page start //-->

	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ asset('template_dashboard/assets/images/login/1.jpg') }}" alt="looginpage" /></div>
	            <div class="col-xl-7 p-0">
	                <div class="login-card">
	                    <form class="theme-form login-form" method="POST" action="{{ url('login') }}">
                            @csrf

	                        <h4>Login</h4>
	                        <h6>Welcome back! Log in to your account.</h6>


	                        <div class="form-group">
	                            <label>Email Address</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
	                                <input class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                </div>
	                        </div>
	                        <div class="form-group">
	                            <label>Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
	                                <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    {{-- <div class="show-hide"><span class="show"> </span></div> --}}

	                        </div><br>

                                @if (Route::has('password.request'))
                                <a class="link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
	                        </div><br>
	                        <button class="btn btn-primary btn-block" type="submit">Login</button><br>

	                        <p>Don't have account?<a class="ms-2" href="/register">Create Account</a></p>
</div>
	                </div>
	            </div> </form>
	        </div>
	    </div>




        <!-- error page end //-->
        <!-- latest jquery-->
        <script src="{{ asset('template_dashboard/assets/js/jquery-3.5.1.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('template_dashboard/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('template_dashboard/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('template_dashboard/assets/js/config.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('template_dashboard/assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('template_dashboard/assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('template_dashboard/assets/js/script.js') }}"></script>
<!-- Plugin used-->
    </body>
</html>



