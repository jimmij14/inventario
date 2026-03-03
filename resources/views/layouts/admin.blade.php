<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>

    <div id="wrapper">

        @include('partials.topbar')

        @include('partials.sidebar')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>

            @include('partials.footer')

        </div>

    </div>

    @include('partials.scripts')

</body>
</html>