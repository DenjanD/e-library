@section('header')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('vendor/bootstrap/css/bootstrap.css') }}">
    <title>{{ $title }} - ELibrary</title>

    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>
@endsection

@section('navbar')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('home') }}">E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link @if($title == 'Beranda') active @endif" href="{{ url('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($title == 'Pinjaman') active @endif" href="{{ url('myorder') }}">Pinjaman Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($title == 'Profil') active @endif" href="{{ url('profile') }}">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endsection

@section('footer')
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ url('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endsection