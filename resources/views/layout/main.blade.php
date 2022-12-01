<!-- <!doctype html> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="/images/favicon/sengked_logo.ico">
    <link href="/css/trix.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebar.css">
    <title>{{$title}}</title>
    @stack('styles')


</head>

<body id="body-pd">
    <header class="header hed" id="header">
        <div class="header_toggle">
            <img src="/images/icon/menu.svg" alt="" id="header-toggle">
        </div>



        <div class="flex-shrink-0 dropdown px-3 border-start">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <p class=" text-gray-600 small d-inline me-2">{{auth()->user()->username}}</p>
                <img src="/images/user.png" alt="mdo" width="40" height="40" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">

                <li><a class="dropdown-item" href="{{Route('logout')}}">Sign out</a></li>
            </ul>
        </div>
    </header>
    <div class="title-header">
        <h3>&nbsp;</h3>
    </div>

    @include('sidebar.sidebar')


    <div class="container shadow p-4 badan" style="background-color: #e5fff7;">
        @yield('container')
    </div>
    @include('sweetalert::alert')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script type="text/javascript" src="/js/trix.js"></script>
    <script src="/js/mian.js"></script>
    </script>
    <script>
        feather.replace();
    </script>
    @stack('scripts')


</body>

</html>
