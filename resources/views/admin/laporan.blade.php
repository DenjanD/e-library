<!DOCTYPE html>
<html lang="en">

@include('admin/template')

@yield('head')

<body class="sb-nav-fixed">
    @yield('navbar')

    <div id="layoutSidenav">
        @yield('sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Laporan Peminjaman Buku</h1>
                    <hr>
                    <form action="{{ url('admin/laporan/export') }}" method="post">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="mt-3">Peminjam</label>
                                <select class="selectpicker form-control" data-live-search="true" id="listPeminjam" name="peminjam">
                                    <option>--- Pilih Peminjam ---</option>
                                    @foreach ($dataPem as $dp)
                                    <option>{{ $dp->nama_anggota }}</option>
                                    @endforeach
                                </select>
                                <label class="mt-3">Buku</label>
                                <select class="selectpicker form-control" data-live-search="true" id="listBuku" name="buku">
                                    <option>--- Pilih Buku ---</option>
                                    @foreach ($dataBuk as $db)
                                    <option>{{ $db->judul }}</option>
                                    @endforeach
                                </select>
                                <label class="mt-3">Tanggal Pinjam</label>
                                <input type="date" class="form-control" name="tglPinjam">
                            </div>
                            <div class="col-md-6">
                                <label class="mt-3">Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tglKembali">
                                <label class="mt-3">Verifikator</label>
                                <select class="selectpicker form-control" data-live-search="true" id="listAdm" name="verifikator">
                                    <option>--- Pilih Verifikator ---</option>
                                    @foreach ($dataAdm as $da)
                                    <option>{{ $da->nama_admin }}</option>
                                    @endforeach
                                </select>
                                <label class="mt-3">Status Denda</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="denda" value="berdenda" id="dendaCheck">
                                    <label class="form-check-label" for="dendaCheck">
                                        Memiliki Denda
                                    </label>
                                </div>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="checkbox" name="tidakDenda" value="tidakdenda" id="dendaCheck">
                                    <label class="form-check-label" for="dendaCheck">
                                        Tidak Memiliki Denda
                                    </label>
                                </div>
                                <label class="mt-3">Export data sebagai: &nbsp;</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radioExport" id="inlineRadio1" value="pdf">
                                    <label class="form-check-label" for="inlineRadio1">PDF</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radioExport" id="inlineRadio2" value="excel">
                                    <label class="form-check-label" for="inlineRadio2">Excel</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary btn-block" value="Export data">
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            @yield('footer')
        </div>
    </div>
    @yield('scripts')
    <script src="{{ url('bs/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ url('bs/dist/js/bootstrap-select.min.js') }}"></script>
    <script>
        $(function() {
            $('#listPeminjam').selectpicker();
        })
    </script>
</body>

</html>