<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - ELibrary Admin</title>
    <link href="{{ url('css/sb-style.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">ELibrary</h3>
                                </div>
                                <div class="card-body">
                                    @if($msg != '')
                                    <div class="alert alert-success" role="alert" id="warnPass" style="display: none;">
                                        {{ $msg }}
                                    </div>
                                    @endif
                                    <form action="admin/login" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputId">Id</label>
                                            <input class="form-control py-4" id="inputId" type="text" name="id" placeholder="Masukkan Id Anda" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Masukkan Password" />
                                        </div>
                                        <div class="form-group d-flex align-items-centermt-4 mb-0">
                                            <input type="submit" class="btn btn-primary btn-block" value="Login">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ url('js/scripts.js') }}"></script>
</body>

</html>