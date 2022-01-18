<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">

    <title>Home</title>
</head>

<body>

    @if (Auth::check())

    @if (Auth::user()->role_id == 2)
    {{-- Member --}}
    {{-- Update layout --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid " id="navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Drinkaloo</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-light" href="/">Home</a>
                </li>
            </ul>
            <div class="collapse navbar-collapse d-flex justify-content-end me-2">
                <div class="input-group d-flex justify-content-end">
                    <span class="fas fa-search input-group-text py-2 dark-theme-form">
                    </span>
                    <div class="width-300">
                        <form action="/Search" method="GET">
                            <input class="form-control mr-sm-2 dark-theme-form" name="search" type="search" placeholder="Search"
                            aria-label="Search">
                        </form>
                    </div>
                </div>

                <div class="mx-3">
                    <ul class="navbar-nav">
                        <li class="nav-item active mx-2 d-flex align-items-center">
                            <a href='/Cart' class="text-light nav-link">
                                <i class="fas fa-shopping-cart gray-color fs-4 "></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown" href="#" id="navbarDDLProfile" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{Storage::url(Session::get('mySession')['profilePic'])}}" class="rounded-circle" alt="profile-pic w-25" width="27px" height="27px">

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDDLProfile">
                                <li><a class="dropdown-item" href="/Profile">Profile</a></li>
                                <li><a class="dropdown-item" href="/TransactionHistory">Transaction History</a></li>
                                <li><a class="dropdown-item" href="/Logout">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Admin --}}
            @elseif (Auth::user()->role_id == 1)
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
                <div class="container-fluid " id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Drinkaloo</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-light" href="/">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-light" href="/ManageDrink">Manage Drink</a>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse d-flex justify-content-end me-2">
                        <div class="input-group d-flex justify-content-end">
                            <span class="fas fa-search input-group-text py-2 dark-theme-form">
                            </span>
                            <div class="width-300">
                                <form action="/Search" method="GET">
                                    <input class="form-control mr-sm-2 dark-theme-form" name="search" type="search" placeholder="Search"
                                    aria-label="Search">
                                </form>
                            </div>
                        </div>

                        <div class="mx-3">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown" href="#" id="navbarDDLProfile" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{Storage::url(Session::get('mySession')['profilePic'])}}" class="rounded-circle"
                                            alt="profile-pic w-25" width="27px" height="27px">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDDLProfile">
                                        <li><a class="dropdown-item" href="/Profile">Profile</a></li>
                                        <li><a class="dropdown-item" href="/Logout">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    @else
                    {{-- guest --}}
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
                        <div class="container-fluid " id="navbar">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="/">Drinkaloo</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link text-light" href="/">Home</a>
                                </li>

                            </ul>
                            <div class="collapse navbar-collapse me-2">
                                <div class="input-group d-flex justify-content-end">
                                    <span class="fas fa-search input-group-text py-2 dark-theme-form no-border">
                                    </span>
                                    <div class="width-300">
                                        <form action="/Search" method="GET">
                                            <input class="form-control mr-sm-2 dark-theme-form" name="search" type="search" placeholder="Search"
                                            aria-label="Search">
                                        </form>
                                    </div>

                                </div>

                                <div class="mx-3">
                                    <ul class="navbar-nav mr-auto mx-2">
                                        <li class="nav-item active mx-4">
                                            <a href='/Login' class="text-light nav-link">Login</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a href='/Register' class="text-light nav-link">Register</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </nav>

                    <div class="body-container">
                        @yield('content')
                    </div>

                    <footer class="page-footer p-5 bg-dark footer text-center">
                        <div class="d-flex justify-content-between">
                            <div class="p-0 m-0">
                                <p class="p-0 m-0 fs-5 gray-color">
                                    © 2021 Drinkaloo. All rights reserved.
                                </p>
                            </div>
                            <div class="p-0">
                                <a class="btn-floating btn-fb mx-2" href="#">
                                    <i class="fab fa-facebook fs-5 gray-color"></i>
                                </a>
                                <a class="btn-floating btn-tw mx-2" href="#">
                                    <i class="fab fa-twitter fs-5 gray-color"></i>
                                </a>
                                <a class="btn-floating btn-gplus mx-2" href="#">
                                    <i class="fas fa-link fs-5 gray-color"></i>
                                </a>
                            </div>
                        </div>
                    </footer>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
                        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
                        crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
                        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
                        crossorigin="anonymous"></script>

</body>

</html>
