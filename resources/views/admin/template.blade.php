@section('head')

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - ELibrary Admin</title>
    <link href="{{ url('css/sb-style.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href="{{ url('bs/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ url('bs/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
</head>
<style>
    hr {
        border: 2px solid black;
    }
</style>
@endsection

@section('navbar')

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/veryadmin') }}">E-Library Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('admin/logout') }}">Logout</a>
            </div>
        </li>
    </ul>
</nav>
@endsection
@section('sidebar')
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu Utama</div>
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Inventaris</div>
                <a class="nav-link" href="{{ url('admin/katb') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Kategori Buku
                </a>
                <a class="nav-link" href="{{ url('admin/buku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Buku
                </a>
                <a class="nav-link" href="{{ url('admin/anggota') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Anggota Perpus
                </a>
                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link" href="{{ url('admin/transaksi') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Peminjaman Buku
                </a>
                <a class="nav-link" href="{{ url('admin/laporan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Laporan Peminjaman
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk sebagai:</div>
            {{ session()->get('name') }}
        </div>
    </nav>
</div>
@endsection

@section('footer')
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; E-Library 2021</div>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{ url('js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="{{ url('js/datatables-demo.js') }}"></script>
@endsection