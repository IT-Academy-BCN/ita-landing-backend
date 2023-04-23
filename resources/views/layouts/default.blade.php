<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <div class="container max-w-max">
        <header>
            @include('partials.header')
        </header>
        <div id="main" class="row">
            @yield('content')
        </div>
        <footer>
            @include('partials.footer')
        </footer>
    </div>
</body>

</html>