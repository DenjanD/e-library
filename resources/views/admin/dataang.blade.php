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
                    <h1 class="mt-4">Data Anggota</h1>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="ml-auto mb-3">
                                    <!--<button data-target="#addModal" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>-->
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Id_Anggota</th>
                                                    <th>Username</th>
                                                    <th>Nama Anggota</th>
                                                    <th>Telp</th>
                                                    <th>Alamat</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id_Anggota</th>
                                                    <th>Username</th>
                                                    <th>Nama Anggota</th>
                                                    <th>Telp</th>
                                                    <th>Alamat</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($dataAng as $d)
                                                <tr>
                                                    <td>{{ $d->id_anggota }}</td>
                                                    <td>{{ $d->username }}</td>
                                                    <td>{{ $d->nama_anggota }}</td>
                                                    <td>{{ $d->telp }}</td>
                                                    <td>{{ $d->alamat }}</td>
                                                    <td>
                                                        @if($d->jenis_kelamin == 'L')
                                                        Laki-Laki
                                                        @elseif($d->jenis_kelamin == 'P')
                                                        Perempuan
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!--<button class="btn btn-success btn-sm" onclick="editModal({{ $d->id_anggota }})" data-target="#editModal" data-toggle="modal"><i class="fa fa-pen"></i></button>-->
                                                        <button class="btn btn-primary btn-sm" onclick="detailModal({{ $d->id_anggota }})" data-target="#detailsModal" data-toggle="modal"><i class="fa fa-align-justify"></i></button>
                                                        <!--<button class="btn btn-danger btn-sm" onclick="prepDelete({{ $d->id_anggota }})" data-target="#deleteModal" data-toggle="modal"><i class="fa fa-trash"></i></button>-->
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
                                    <h5 class="modal-title" id="addModalTitle">Anggota baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/anggota') }}" method="post">
                                        @csrf
                                        <label class="mt-3">Nama Anggota</label>
                                        <input class="form-control" type="text" name="nama_anggota" placeholder="Masukkan nama anggota">
                                        <label class="mt-3">Telepon</label>
                                        <input class="form-control" type="text" name="telp" placeholder="Masukkan telepon anggota">
                                        <label class="mt-3">Alamat</label>
                                        <input class="form-control" type="text" name="alamat" placeholder="Masukkan alamat anggota">
                                        <label class="mt-3">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin">
                                            <option>--- Pilih Jenis Kelamin ---</option>
                                            <option>Laki-Laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                        <label class="mt-3">Username Anggota</label>
                                        <input class="form-control" type="text" name="username" placeholder="Masukkan username anggota">
                                        <label class="mt-3">Password Anggota</label>
                                        <input class="form-control" type="password" name="password">
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
                                    <h5 class="modal-title" id="editModalTitle">Ubah data anggota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/anggota/update') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="editId" name="anggota" value="">
                                        <label class="mt-3">Nama Anggota</label>
                                        <input class="form-control" type="text" id="edit1" name="nama_anggota" value="">
                                        <label class="mt-3">Telepon</label>
                                        <input class="form-control" type="text" id="edit2" name="telp" value="">
                                        <label class="mt-3">Alamat</label>
                                        <input class="form-control" type="text" id="edit3" name="alamat" value="">
                                        <label class="mt-3">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="edit4" class="form-control">
                                            <option>--- Pilih Jenis Kelamin ---</option>
                                            <option>Laki-Laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                        <label class="mt-3">Username</label>
                                        <input class="form-control" type="text" id="edit5" name="username">
                                        <label class="mt-3">Password</label>
                                        <input class="form-control" type="text" id="edit6" name="password">
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
                                    <h5 class="modal-title" id="detailsModalTitle">Detail data anggota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mt-3">Id Anggota</h6>
                                            <p id="detail1"></p>
                                            <h6 class="mt-3">Nama Anggota</h6>
                                            <p id="detail2"></p>
                                            <h6 class="mt-3">Tanggal Lahir</h6>
                                            <p id="detail3"></p>
                                            <h6 class="mt-3">Telepon</h6>
                                            <p id="detail4"></p>
                                            <h6 class="mt-3">Alamat</h6>
                                            <p id="detail5"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mt-3">Jenis Kelamin</h6>
                                            <p id="detail6"></p>
                                            <h6 class="mt-3">Username</h6>
                                            <p id="detail7"></p>
                                            <h6 class="mt-3">Email</h6>
                                            <p id="detail8"></p>
                                            <h6 class="mt-3">Foto</h6>
                                            <img id="detail9" style="width:100px;height:150px;">
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
                                    <h5 class="modal-title" id="deleteModallTitle">Hapus data anggota</h5>
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
                url: "{{ url('admin/anggota') }}" + "/" + getId,
                dataType: "json",
                success: function(response) {
                    response.detailData.forEach(function(item) {
                        document.getElementById('editId').value = item.id_anggota;
                        document.getElementById('edit1').value = item.nama_anggota;
                        document.getElementById('edit2').value = item.telp;
                        document.getElementById('edit3').value = item.alamat;
                        if (item.jenis_kelamin == 'L') {
                            document.getElementById('edit4').value = 'Laki-Laki';
                        }
                        if (item.jenis_kelamin == 'P') {
                            document.getElementById('edit4').value = 'Perempuan';
                        }
                        document.getElementById('edit5').value = item.username;
                    });
                }
            });
        }

        function detailModal(getId) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/anggota') }}" + "/" + getId,
                dataType: "json",
                success: function(response) {
                    response.detailData.forEach(function(item) {
                        document.getElementById('detail1').innerHTML = item.id_anggota;
                        document.getElementById('detail2').innerHTML = item.nama_anggota;
                        document.getElementById('detail3').innerHTML = item.tgl_lahir;
                        document.getElementById('detail4').innerHTML = item.telp;
                        document.getElementById('detail5').innerHTML = item.alamat;
                        if (item.jenis_kelamin == 'L') {
                            document.getElementById('detail6').innerHTML = 'Laki-Laki';
                        }
                        if (item.jenis_kelamin == 'P') {
                            document.getElementById('detai6').innerHTML = 'Perempuan';
                        }
                        document.getElementById('detail7').innerHTML = item.username;
                        document.getElementById('detail8').innerHTML = item.email;
                        document.getElementById('detail9').setAttribute('src', "{{ url('userPhotos') }}" + '/' + item.foto);
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
                url: "{{ url('admin/anggota') }}" + "/" + document.getElementById('deleteId').value,
                dataType: "json",
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>