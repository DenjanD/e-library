<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Id Transaksi</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Komentar</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Jumlah Denda</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($peminjaman as $p)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$p->id_transaksi}}</td>
                <td>{{$p->id_peminjam}}</td>
                <td>{{$p->id_buku}}</td>
                <td>{{$p->komentar}}</td>
                <td>{{$p->tanggal_pinjam}}</td>
                <td>{{$p->tanggal_kembali}}</td>
                <td>{{$p->jumlah_denda}}</td>
                <td>{{$p->id_verifikator}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>