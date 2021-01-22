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
                    <h1 class="mt-4">Data Kategori Buku</h1>
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
                                                    <th>Id_Kategori</th>
                                                    <th>Nama Kategori</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id_Kategori</th>
                                                    <th>Nama Kategori</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($dataKat as $d)
                                                <tr>
                                                    <td>{{ $d->id_kategori }}</td>
                                                    <td>{{ $d->nama }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="editModal({{ $d->id_kategori }})" data-target="#editModal" data-toggle="modal"><i class="fa fa-pen"></i></button>
                                                        <button class="btn btn-danger btn-sm" onclick="prepDelete({{ $d->id_kategori }})" data-target="#deleteModal" data-toggle="modal"><i class="fa fa-trash"></i></button>
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
                                    <h5 class="modal-title" id="addModalTitle">Kategori buku baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/katb') }}" method="post">
                                        @csrf
                                        <label>Nama Kategori</label>
                                        <input class="form-control" type="text" name="nama" placeholder="Masukkan nama kategori baru">
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
                                    <h5 class="modal-title" id="editModalTitle">Ubah data kategori</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('admin/katb/update') }}" method="post">
                                        @csrf
                                        <input type="hidden" id="editId" name="kategori" value="">
                                        <label>Nama Kategori</label>
                                        <input class="form-control" type="text" id="edit1" name="nama" value="">
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
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModallTitle">Hapus data kategori</h5>
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
                url: "{{ url('admin/katb') }}" + "/" + getId,
                dataType: "json",
                success: function(response) {
                    response.detailData.forEach(function(item) {
                        document.getElementById('editId').value = item.id_kategori;
                        document.getElementById('edit1').value = item.nama;
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
                url: "{{ url('admin/katb') }}" + "/" + document.getElementById('deleteId').value,
                dataType: "json",
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>