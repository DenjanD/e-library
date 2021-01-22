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
                    <h1 class="mt-4">Data Buku</h1>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="ml-auto mb-3">
                                    <button data-target="#addModal" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Id_Buku</th>
                                                    <th>Judul</th>
                                                    <th>Penulis</th>
                                                    <th>Penerbit</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                    <th>Gambar</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id_Buku</th>
                                                    <th>Judul</th>
                                                    <th>Penulis</th>
                                                    <th>Penerbit</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                    <th>Gambar</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($dataBuku as $d)
                                                <tr>
                                                    <td>{{ $d->id_buku }}</td>
                                                    <td>{{ $d->judul }}</td>
                                                    <td>{{ $d->penulis }}</td>
                                                    <td>{{ $d->penerbit }}</td>
                                                    <td>{{ $d->kategoribuku }}</td>
                                                    <td>
                                                        @if($d->status == 'D')
                                                        <badege class="badge badge-secondary">Dipinjam</badege>
                                                        @elseif($d->status == 'T')
                                                        <badge class="badge badge-primary">Tersedia</badge>
                                                        @elseif($d->status == 'K')
                                                        <badge class="badge badge-danger">Kosong</badge>
                                                        @endif
                                                    </td>
                                                    <td><img src="{{ url('bukuPhotos') }}/{{ $d->gambar }}" style="max-width: 50px;max-height:100px;"></td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="editModal({{ $d->id_buku }})" data-target="#editModal" data-toggle="modal"><i class="fa fa-pen"></i></button>
                                                        <button class="btn btn-primary btn-sm" onclick="detailModal({{ $d->id_buku }})" data-target="#detailsModal" data-toggle="modal"><i class="fa fa-align-justify"></i></button>
                                                        <button class="btn btn-danger btn-sm" onclick="prepDelete({{ $d->id_buku }})" data-target="#deleteModal" data-toggle="modal"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Modal -->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalTitle">Buku baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/buku') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label class="mt-3">Judul Buku</label>
                                        <input class="form-control" type="text" name="judul" placeholder="Masukkan judul buku">
                                        <label class="mt-3">Penulis</label>
                                        <input class="form-control" type="text" name="penulis" placeholder="Masukkan penulis buku">
                                        <label class="mt-3">Penerbit</label>
                                        <input class="form-control" type="text" name="penerbit" placeholder="Masukkan penerbit buku">
                                        <label class="mt-3">Kategori</label>
                                        <select class="form-control" name="kategori">
                                            <option>--- Pilih Kategori ---</option>
                                            @foreach($dataKat as $k)
                                            <option>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                        <label class="mt-3">Sinopsis</label>
                                        <textarea class="form-control" type="text" name="sinopsis" placeholder="Masukkan sinopsis"></textarea>
                                        <label class="mt-3">Gambar</label>
                                        <input class="form-control" type="file" name="gambar">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <input type="submit" class="btn btn-primary" value="Tambah data">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./modal -->
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalTitle">Ubah data buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/buku/update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" id="editId" name="buku" value="">
                                        <label class="mt-3">Judul Buku</label>
                                        <input class="form-control" type="text" id="edit1" name="judul" value="">
                                        <label class="mt-3">Penulis</label>
                                        <input class="form-control" type="text" id="edit2" name="penulis" value="">
                                        <label class="mt-3">Penerbit</label>
                                        <input class="form-control" type="text" id="edit3" name="penerbit" value="">
                                        <label class="mt-3">Kategori</label>
                                        <select name="kategori" id="edit4" class="form-control">
                                            <option>--- Pilih Kategori ---</option>
                                            @foreach($dataKat as $k)
                                            <option>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                        <label class="mt-3">Sinopsis</label>
                                        <textarea class="form-control" type="text" id="edit5" name="sinopsis"></textarea>
                                        <label class="mt-3">Status</label>
                                        <select name="status" id="edit6" class="form-control">
                                            <option>--- Pilih Status ---</option>
                                            <option>Tersedia</option>
                                            <option>Dipinjam</option>
                                            <option>Kosong</option>
                                        </select>
                                        <label class="mt-3">Gambar</label>
                                        <input class="form-control" type="file" name="gambar">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <input type="submit" class="btn btn-primary" value="Ubah data">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./modal -->
                    <!-- Details Modal -->
                    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailsModalTitle">Detail data buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mt-3">Id Buku</h6>
                                            <p id="detail1"></p>
                                            <h6 class="mt-3">Judul Buku</h6>
                                            <p id="detail2"></p>
                                            <h6 class="mt-3">Penulis</h6>
                                            <p id="detail3"></p>
                                            <h6 class="mt-3">Penerbit</h6>
                                            <p id="detail4"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mt-3">Kategori</h6>
                                            <p id="detail5"></p>
                                            <h6 class="mt-3">Status</h6>
                                            <p id="detail7"></p>
                                            <h6 class="mt-3">Gambar</h6>
                                            <img id="detail8" style="width:100px;height:150px;">
                                        </div>
                                        <div class="col-md-12">
                                            <h6 class="mt-3">Sinopsis</h6>
                                            <p id="detail6"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./modal -->
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModallTitle">Hapus data buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="deleteId" value="">
                                    Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button id="deleteButt" onclick="deleteModal()" class="btn btn-danger">Hapus data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./modal -->
                </div>
            </main>
            @yield('footer')
        </div>
    </div>
    @yield('scripts')
    <script>
        function editModal(getId) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/buku') }}" + "/" + getId,
                dataType: "json",
                success: function(response) {
                    response.detailData.forEach(function(item) {
                        document.getElementById('editId').value = item.id_buku;
                        document.getElementById('edit1').value = item.judul;
                        document.getElementById('edit2').value = item.penulis;
                        document.getElementById('edit3').value = item.penerbit;
                        document.getElementById('edit4').value = item.kategoribuku;
                        document.getElementById('edit5').value = item.sinopsis;
                        if (item.status == 'T') {
                            document.getElementById('edit6').value = 'Tersedia';
                        }
                        if (item.status == 'D') {
                            document.getElementById('edit6').value = 'Dipinjam';
                        }
                        if (item.status == 'K') {
                            document.getElementById('edit6').value = 'Kosong';
                        }
                    });
                }
            });
        }

        function detailModal(getId) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/buku') }}" + "/" + getId,
                dataType: "json",
                success: function(response) {
                    response.detailData.forEach(function(item) {
                        console.log('detail jalan');
                        document.getElementById('detail1').innerHTML = item.id_buku;
                        document.getElementById('detail2').innerHTML = item.judul;
                        document.getElementById('detail3').innerHTML = item.penulis;
                        document.getElementById('detail4').innerHTML = item.penerbit;
                        document.getElementById('detail5').innerHTML = item.kategoribuku;
                        document.getElementById('detail6').innerHTML = item.sinopsis;
                        if (item.status == 'T') {
                            document.getElementById('detail7').innerHTML = 'Tersedia';
                        }
                        if (item.status == 'D') {
                            document.getElementById('detail7').innerHTML = 'Dipinjam';
                        }
                        if (item.status == 'K') {
                            document.getElementById('detail7').innerHTML = 'Kosong';
                        }
                        document.getElementById('detail8').setAttribute('src', "{{ url('bukuPhotos') }}" + '/' + item.gambar);
                    });
                }
            });
        }

        function prepDelete(getId) {
            document.getElementById('deleteId').value = getId;
        }

        function deleteModal() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "{{ url('admin/buku') }}" + "/" + document.getElementById('deleteId').value,
                dataType: "json",
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>