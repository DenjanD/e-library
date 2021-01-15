<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('vendor/bootstrap/css/bootstrap.css') }}">
    <title>Details - ELibrary</title>

    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>
<body>

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
                    <a class="nav-link" href="#">Beranda
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pinjaman Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Details -->
            @foreach($detailsData as $d)
            <div class="row mt-5">
                <div class="col-md-5">
                    <img src="{{ url('http://placehold.it/400x300') }}">
                </div>
                <div class="col-md-7">
                    <h3>{{ $d->judul }}</h3>
                </div>
            </div>
            @endforeach
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>