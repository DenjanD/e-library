<!DOCTYPE html>
<html lang="en">

@php $title = 'Profil'; @endphp
@include('template')
<style>
    .avatar {
        width: 300px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .avatar img {
        width: 300px;
        height: 300px;
        border-radius: 100%;
        border: 10px solid white;
        margin-top: 30px;
    }

    .avatar a {
        border-radius: 100%;
    }

    #upload {
        display: none
    }
</style>
@yield('header')

<body>
    @yield('navbar')

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-12 mb-5">

                <!-- Avatar -->
                @foreach($profileData as $p)
                <div class="avatar">
                    <img src="{{ url('userPhotos') }}/{{ $p->foto }}">
                    <form id="form" action="{{ url('profile/uppict') }}" onchange="form.submit()" method="post" enctype="multipart/form-data">
                        @csrf
                        <input id="upload" type="file" name="foto" />
                        <a href="" id="upload_link">Ubah foto profil</a>
                    </form>
                </div>
                @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <!-- Profil -->
                <div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h6>Nama</h6>
                            {{ $p->nama_anggota }}
                        </li>
                        <li class="list-group-item">
                            <h6>Tanggal Lahir</h6>
                            {{ $p->tgl_lahir }}
                        </li>
                        <li class="list-group-item">
                            <h6>Jenis Kelamin</h6>
                            @if($p->jenis_kelamin == 'L')
                            Laki-Laki
                            @else
                            Perempuan
                            @endif
                        </li>
                        <li class="list-group-item">
                            <h6>Alamat</h6>
                            {{ $p->alamat }}
                        </li>
                        <li class="list-group-item">
                            <h6>E-Mail</h6>
                            {{ $p->email }}
                        </li>
                        <li class="list-group-item">
                            <h6>Nomor HP</h6>
                            {{ $p->telp }}
                        </li>
                        <li class="list-group-item">
                            <a href="#" id="changePass">Ubah Password</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal Pass -->
    <div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="passModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passModalLongTitle">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert" id="warnOldPass" style="display: none;">
                        Password lama salah!
                    </div>
                    <div class="alert alert-warning" role="alert" id="warnNewPass" style="display: none;">
                        Konfirmasi password baru tidak sama!
                    </div>
                    <form action="profile/cpass" method="post" onsubmit="return checkPass()">
                        @csrf
                        <label class="mt-1">Password Lama</label>
                        <input type="password" class="form-control" id="oldPass">
                        <label class="mt-3">Password Baru</label>
                        <input type="password" class="form-control" id="newPass">
                        <label class="mt-3">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password" id="confNewPass">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Ubah Password">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('footer')
    <script>
        $(function() {
            $("#upload_link").on('click', function(e) {
                e.preventDefault();
                $("#upload:hidden").trigger('click');
            });
            $("#changePass").on('click', function(e) {
                $('#passModal').modal('toggle');
                e.preventDefault();
            });
        });

        var tmp = null;
        $.ajax({
            type: "GET",
            url: "{{ url('profile/checkpass') }}",
            dataType: "json",
            success: function(response) {
                tmp = response.pass;
            }
        });

        function checkPass() {
            var oldPass = document.getElementById('oldPass').value;
            var newPass = document.getElementById('newPass').value;
            var confNewPass = document.getElementById('confNewPass').value;

            if (this.tmp == oldPass) {
                document.getElementById('warnOldPass').style.display = 'none'
                if (newPass == confNewPass) {
                    document.getElementById('warnNewPass').style.display = 'none'
                    return true;
                } else {
                    document.getElementById('warnNewPass').style.display = 'block'
                    return false;
                }
            } else {
                document.getElementById('warnOldPass').style.display = 'block'
                return false;
            }
        }
    </script>
</body>

</html>