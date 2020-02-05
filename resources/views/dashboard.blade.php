<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/" />
    <link rel="shortcut icon" type="image/png"  href="{{{ asset('/img/logo/PAO_Logo.png') }}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Public Attorney's Office</title>
    <link rel="stylesheet" href="/css/app.css">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ])
            !!};
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        @include('includes.dashboard.navbar')

        @include('includes.dashboard.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                    <vue-progress-bar></vue-progress-bar>
                </div>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
    </div>

    @auth
        <script>
            window.user = @json(auth()->user())
        </script>
    @endauth
    <script src="/js/app.js"></script>
    <style>
        .fr-wrapper > div:first-child {
            display: none !important;
        }
    </style>
    <script>
        window.onload = () => {
            let appendhtml = "<div class='fr-element fr-view' dir='auto' contenteditable='true' aria-disabled='false' spellcheck='true'><p id='postCont'><br></p></div>"

            $('.fr-wrapper.show-placeholder').children().hide()

            $('.fr-element.fr-view').show()

        }

    </script>
</body>

</html>
