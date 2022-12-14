<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
<body class="bg-dark">
<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.storeregister') }}">
                @csrf
                <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                            <label for="name">Username</label>
                        </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required">
                        <label for="inputEmail">Email address</label>
                    </div>
                </div>
                <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                </div>
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Register">

            </form>
            <div class="text-center mt-2">
                <a class="d-block small mt-3" href="{{url('admin/login')}}">Login Page</a>
                <a class="d-block small" href="{{route('admin.reset-form')}}">Forgot Password?</a>
            </div>
            <div class="text-center mb-3">
                <script type="text/javascript">window.setTimeout("document.getElementById('popmessage').style.display='none';", 6000); </script>
                @if(session()->has('error'))
                    <div id="popmessage" class="text-danger form-control-feedback">
                       @php $errors =  session()->get('error');  @endphp
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br/>
                        @endforeach
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
