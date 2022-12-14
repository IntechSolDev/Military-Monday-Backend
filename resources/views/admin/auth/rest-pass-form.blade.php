<!DOCTYPE html>
<html lang="en">

@include('admin.includes.head')
<body class="bg-dark">

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Reset Password</div>
        <div class="card-body">
            <div class="text-center mb-4">
                <h4>Forgot your password?</h4>
                <p>Enter your email address and we will send you instructions on how to reset your password.</p>
            </div>
            <form method="post" action="{{ route('admin.forgot') }}">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus">
                        <label for="inputEmail">Enter email address</label>
                    </div>
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="Reset Password">

            </form>
            <div class="text-center mt-2">
                <a class="d-block small" href="{{url('admin/login')}}">Login Page</a>
            </div>
        </div>
        <div class=" mb-3 text-center">
            <script type="text/javascript">window.setTimeout("document.getElementById('popmessage').style.display='none';", 6000); </script>
            @if(session()->has('error'))
                <div id="popmessage" class="text-danger  form-control-feedback">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if(session()->has('success'))
                <div id="popmessage" class="text-success  form-control-feedback">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin.includes.footer')

</body>


</html>

