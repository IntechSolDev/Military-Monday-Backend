<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.storelogin') }}">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                        <label for="inputEmail">Email address</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
                        <label for="inputPassword">Password</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me">
                            Remember Password
                        </label>
                    </div>
                </div>
                <input class="btn btn-primary  btn-block" type="submit" value="Login">
            </form>
            <div class="text-center mt-2">
                <a class="d-block small" href="{{route('admin.reset-form')}}">Forgot Password</a>
            </div>
            <div class="text-center mb-3">
                <script type="text/javascript">window.setTimeout("document.getElementById('popmessage').style.display='none';", 6000); </script>
                @if(session()->has('error'))
                    <div id="popmessage" class="text-danger form-control-feedback">
                            {{ session()->get('error') }}<br/>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div id="popmessage" class="text-success form-control-feedback">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
</body>
</html>

