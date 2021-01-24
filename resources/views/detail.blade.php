<!DOCTYPE html>
<html lang="en">

@php $title = 'Details'; @endphp
@include('template')

@yield('header')

<body>

    @yield('navbar')

    <!-- Page Content -->
    <div class="container">

        <!-- Details -->
        @foreach($detailsData as $d)
        <div class="row mt-5 mb-4">
            <div class="col-md-5 text-center">
                <img src="{{ url('bukuPhotos') }}/{{ $d->gambar }}" style="width: 250px; height: 380px;">
                @if($d->status == 'T')
                <button class="btn btn-primary btn-block mt-4" data-toggle="modal" data-target="#exampleModal">Pinjam Buku</button>
                @elseif($d->status == 'D')
                <button class="btn btn-secondary btn-block mt-4" disabled>Sedang dipinjam</button>
                @elseif($d->status == 'K')
                <button class="btn btn-secondary btn-block mt-4" disabled>Buku kosong</button>
                @endif
            </div>
            <div class="col-md-7">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h3>Judul Buku</h3>
                        <p>{{ $d->judul }}</p>
                        <h3>Penulis</h3>
                        <p>{{ $d->penulis }}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Penerbit</h3>
                        <p>{{ $d->penerbit }}</p>
                        <h3>Kategori Buku</h3>
                        <p>{{ $d->kategori }}</p>
                        <input type="hidden" value="{{ $d->id_buku }}" id="sec">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-12">
                        <h3>Sinopsis</h3>
                        <p>{{ $d->sinopsis }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- /.row -->

        <!-- Book reviews -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>Ulasan pembaca</h3>
                <div class="row mt-1">
                    <div class="col-md-12">
                        @if($reviews == '')
                        <p>Tidak ada ulasan untuk buku ini.</p>
                        @else
                        @foreach($reviews as $r)
                        @if($r->komentar != '-' && $r->komentar != null)
                        <div class="card shadow-sm mt-4">
                            <div class="card-body">
                                <h6>{{ $r->peminjam }}</h6>
                                <p>{{ $r->komentar }}</p>
                                <small>{{ $r->tanggal_kembali }}</small>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Confirm Modal -->
        <div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pinjam buku</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('transaction') }}" method="post">
                            @csrf
                            Anda yakin ingin meminjam buku ini?
                            <input type="hidden" value="" id="prep" name="buku">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Pinjam">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

    </div>
    <!-- /.container -->

    @yield('footer')
    <script>
        var prep = document.getElementById('sec').value;
        document.getElementById('prep').value = prep;
    </script>
</body>

</html>