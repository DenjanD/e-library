<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('vendor/bootstrap/css/bootstrap.css') }}">
    <title>Home - ELibrary</title>

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
        <a class="navbar-brand" href="home">E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
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

    <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4">Daftar Buku</h1>
            <div class="list-group">
                @foreach($kb as $katB)
                    <a href="search?search={{ $katB->id_kategori }}" class="list-group-item">{{ $katB->nama }}</a>
                @endforeach
            </div>

        </div>
    <!-- /.col-lg-3 -->

    <div class="col-lg-9">

        <!-- Search Bar -->          
        <div class="row">
            <div class="col-md-10">
            <form action="search" method="get">
                <label for="bookSearch" class="mt-3">Cari Buku</label>
                <input type="text" class="form-control mb-4" id="bookSearch" name="search">
            </div>
            <div class="col-md-2">
                <input type="submit" value="Cari" class="btn btn-primary mt-5">
            </form>
            </div>
        </div>

        <!-- Featured -->
        <div class="row">

            @foreach($buku as $b)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="http://placehold.it/700x400" alt="">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ $b->judul }}
                    </h4>
                    <p>{{ $b->penulis }}</p>
                    <p class="card-text" style="color: white;">
                        @if($b->status == 'T')
                            <span class="badge rounded-pill bg-primary">Tersedia</span>
                        @endif
                        @if($b->status == 'D')
                            <span class="badge rounded-pill bg-secondary">Dipinjam</span>
                        @endif
                        @if($b->status == 'K')
                            <span class="badge rounded-pill bg-danger">Kosong</span>
                        @endif
                    </p>
                </div>
                <div class="card-footer">
                    <a href="details/{{ $b->id_buku }}" class="btn btn-primary btn-block">Lihat Buku</a>
                </div>
                </div>
            </div>
            @endforeach

        </div>
        <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>