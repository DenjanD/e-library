<!DOCTYPE html>
<html lang="en">

@php $title = 'Beranda'; @endphp
@include('template')

@yield('header')

<body>
    @yield('navbar')

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
                        <div class="card h-100 shadow">
                            <div class="text-center">
                                <img class="card-img-top" src="{{ url('bukuPhotos') }}/{{ $b->gambar }}" alt="" style="max-width: 200px;max-height:280px;">
                            </div>
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

    @yield('footer')

</body>

</html>