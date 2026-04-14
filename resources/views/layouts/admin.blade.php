<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
</head>


<body>

    <div id="wrapper">

        @include('partials.topbar')

        @include('partials.sidebar')

        <div class="content-page">
            <div class="content pt-3">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>

            @include('partials.footer')

        </div>

    </div>

    @include('partials.scripts')

    @yield('scripts')
    @stack('scripts')
    
</body>
</html>