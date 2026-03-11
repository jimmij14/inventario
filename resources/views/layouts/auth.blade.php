<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')

    <style>
    .login-bg{
        background-image: url("{{ asset('Admin/images/login.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    </style>

</head>


<body class="login-bg">

<div class="account-pages mt-0 mb-0">
    <div class="container">

        @yield('content')

    </div>
</div>

@include('partials.scripts')

</body>
</html>