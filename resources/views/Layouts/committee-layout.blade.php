<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>GAPP Committee Dashboard</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fancytree.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="bg-plum-plate bg-animation min-vh-100 d-flex justify-content-center align-items-top">
            <div class="col-md-8">
                <div class="container bg-white p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="card-title mb-0">You are logged in as: <span
                                    class="text-danger">{{ $user->LGN_Name }}</span></div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('committee.dashboard') }}"
                                class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">Home
                            </a>
                            <a href="{{ route('committee.applications') }}"
                                class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">All Applications
                            </a>
                            <button class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">Duplicate
                                Applications</button>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">Logout</button>
                        </form>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


</body>

</html>
