<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'My Title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.styles')

</head>
<body class="hold-transition sidebar-mini layout-fixed text-sm">
<div class="wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')

    <div class="content-wrapper">

        @include('layouts.contentheader')

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    @include('layouts.footer')

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

@include('layouts.scripts')

</body>
</html>
