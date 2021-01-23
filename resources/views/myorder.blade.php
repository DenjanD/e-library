<!DOCTYPE html>
<html lang="en">

@php $title = 'Pinjaman'; @endphp
@include('template')

@yield('header')

<body>

    @yield('navbar')

    <!-- Page Content -->
    <div class="container">
        <div class="row mt-5 mb-4">
            <h3>Pinjaman Saya</h3>
        </div>
        @if(!$orders)
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-5">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <h5 class="card-title">Anda belum pernah meminjam buku.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        @foreach($orders as $o)
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-5">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ url('bukuPhotos') }}/{{ $o->gambar }}" style="max-width: 180px;max-height: 350px;">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">{{ $o->judul }}</h5>
                                <p class="card-text">
                                    Tanggal Pinjam: {{ $o->tanggal_pinjam }}
                                </p>
                                <p class="card-text">
                                    Tanggal Kembali:
                                    @if($o->tanggal_kembali != null)
                                    {{ $o->tanggal_kembali }}
                                    @else
                                    -
                                    @endif
                                </p>
                                <p class="card-text">
                                    Denda Pengembalian:
                                    {{ $o->jumlah_denda }}
                                </p>
                                <p class="card-text"><small class="text-muted">Status:
                                        @if($o->tanggal_kembali != null && $o->id_verifikator != null)
                                        Selesai
                                        @elseif($o->tanggal_kembali != null && $o->id_verifikator == null)
                                        Menunggu verifikasi admin
                                        @else
                                        Dipinjam
                                        @endif
                                    </small></p>
                            </div>
                        </div>
                        <div class="col-md-3 my-auto p-5">
                            <input type="hidden" id="sec" value="{{ $o->id_transaksi }}">
                            @if($o->tanggal_kembali != null && $o->id_verifikator != null)
                            <button class="btn btn-secondary btn-block" disabled>Buku kembali</button>
                            @elseif($o->tanggal_kembali != null && $o->id_verifikator == null)
                            <button class="btn btn-secondary btn-block" disabled>Menunggu verifikasi</button>
                            @else
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalReturn">Kembalikan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <!-- Confirm Modal -->
        <div class="modal fade" id="modalReturn" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalReturnLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReturnLabel">Pengembalian buku</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('transaction/update') }}" method="post">
                            @csrf
                            Anda yakin buku sudah dikembalikan?
                            <input type="hidden" value="" id="prep" name="transaksi">
                            <textarea class="form-control mt-3" name="komentar" placeholder="Tuliskan komentar Anda terhadap buku ini..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Ya">
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