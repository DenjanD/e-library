<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <title>Register - ELibrary</title>
    <style>
        .cust-footer {
            background-color: transparent;
            color: #202020;
        }

        .cust-button {
            border-radius: 20px;
            background-image: linear-gradient(to right, rgba(227, 90, 11, 100), rgba(219, 213, 56, 10));
            border: none;
            height: 40px;
            opacity: 1;
            transition: 0.3s;
        }

        .cust-button:hover {
            opacity: 0.6;
        }

        #app {
            font-family: 'Ebrima', Arial, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #202020;
            margin-top: 0px;
            background-color: #ffffff;
        }

        h1,
        h2 {
            font-weight: normal;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: inline-block;
            margin: 0 10px;
        }

        a {
            color: #b15c23;
        }
    </style>

</head>

<body>
    <div id="app">

        <!-- Content -->
        <div class="container-fluid">

            <!-- Top Template -->
            <div class="row">
                <div class="col-md-12 text-center" style="background-color: transparent; height: 150px;">
                    <img src="assets/logo.png" class="mb-4 mt-4">
                    <h4 style="font-weight: bold;">Daftar anggota baru</h4>
                </div>
            </div>

            <!-- Middle Template -->
            <div class="row d-flex justify-content-center">
                <div class="col-8 col-md-4 shadow p-4" style="background-color: transparent;">

                    <!-- Login Form -->
                    <div class="row justify-content-center">
                        <div class="col-10 col-md-10 align-self-center">
                            <div class="alert alert-warning" role="alert" id="warnPass" style="display: none;">
                                Password tidak cocok!
                            </div>
                            <form method="post" action="register" class="mt-4" onsubmit="return checkPass()">
                                @csrf
                                <label class="form-label">Nama Lengkap</label>
                                <input class="form-control" name="nama_anggota" type="text">
                                <label class="form-label mt-3">Tanggal Lahir</label>
                                <input class="form-control" name="tgl_lahir" type="date">
                                <label class="form-label mt-3">Telepon</label>
                                <input class="form-control" name="telp" type="number">
                                <label class="form-label mt-3">Alamat</label>
                                <input class="form-control" name="alamat" type="text">
                                <label class="form-label mt-3">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option>--- Pilih Jenis Kelamin ---</option>
                                    <option>Laki-Laki</option>
                                    <option>Perempuan</option>
                                </select>
                                <label class="form-label mt-3">Email</label>
                                <input class="form-control" name="email" type="text">
                                <label class="form-label mt-3">Username</label>
                                <input class="form-control" name="username" type="text">
                                <label class="form-label mt-3">Password</label>
                                <input class="form-control mb-2" id="pass" name="password" type="password">
                                <label class="form-label mt-3">Konfirmasi Password</label>
                                <input class="form-control mb-2" id="confirmPass" type="password">
                                <input type="submit" value="Daftar" class="btn btn-primary btn-block mt-4 mb-4 cust-button">
                            </form>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12 text-center">
                                    Sudah punya akun? &nbsp;<a href="{{ url('/') }}">Login di sini</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Bottom Template -->
            <div class="row mt-4">
                <div class="col-md-12 cust-footer text-center">
                    <p class="mt-3 mb-5" style="font-weight: 600;">Copyright &#169; 2020</p>
                </div>
            </div>

        </div>
        <!-- /Content -->

    </div>
    <script>
        function checkPass() {
            var newPass = document.getElementById('pass').value;
            var confNewPass = document.getElementById('confirmPass').value;
            if (newPass == confNewPass) {
                document.getElementById('warnPass').style.display = 'none'
                return true;
            } else {
                document.getElementById('warnPass').style.display = 'block'
                return false;
            }
        }
    </script>
</body>

</html>