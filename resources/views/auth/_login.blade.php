<!DOCTYPE html>
<html>
@include('admin.includes.head')
<body class="login-page">
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="/">
                <img src="{{ asset('public/images/logo.png') }}" width="60" alt="">
            </a>
        </div>
        
    </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7 text-center">
                <img src="{{ asset('public/images/cubanvip.png') }}" width="70%" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">CubanVip</h2>
                    </div>
                    <form method="post" action="{{ route('admin.storelogin') }}">
                        @csrf

                        <div class="input-group custom">
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Username">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="**********">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>
                        <div class="row pb-30">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember</label>
                                </div>
                            </div>
                            <!--<div class="col-6">-->
                            <!--    <div class="forgot-password"><a href="forgot-password.html">Forgot Password</a></div>-->
                            <!--</div>-->
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">

                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">


                                </div>
{{--                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>--}}
{{--                                <div class="input-group mb-0">--}}
{{--                                    <a class="btn btn-outline-primary btn-lg btn-block" href="register.html">Register To Create Account</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
</body>
</html>
