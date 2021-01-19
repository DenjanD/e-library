<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Buku;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::all();

        return response()->json(['data' => $transaksi]);
    }

    public function getUsers(Request $request)
    {
        //pake join dan select buat ambil nama buku
        $getOrders = Transaksi::where('id_peminjam', $request->session()->get('logged'))->get();
        return view('myorder');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'buku' => 'required'
        ]);

        $newTransaksi = new Transaksi([
            'id_peminjam' => $request->session()->get('logged'),
            'id_buku' => $request->input('buku'),
            'komentar' => null,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => null,
            'jumlah_denda' => 0,
            'id_verifikator' => null
        ]);
        $upStatusBuku = Buku::where('id_buku', $request->input('buku'))->first();

        $upStatusBuku->status = 'D';

        if ($newTransaksi->save() && $upStatusBuku->update()) {
            return response()->json(['msg' => 'Transaksi nambah'], 200);
        }
        return response()->json(['msg' => 'Gagal tambah transaksi'], 500);
    }

    public function update(Request $request)
    {
        $getTransaksi = Transaksi::where('id_transaksi', $request->input('transaksi'))->first();

        if ($request->input('komentar') == '') {
            $getTransaksi->komentar = '-';
        } else {
            $getTransaksi->komentar = $request->input('komentar');
        }

        $getTransaksi->tanggal_kembali = date('Y-m-d');

        $cekTglKembali = date('d');
        $cekTglPinjam = date_parse_from_format('Y-m-d', $getTransaksi->tanggal_pinjam)['day'];

        if ($cekTglKembali - $cekTglPinjam > 7) {
            $getTransaksi->jumlah_denda = 5000;
        } else {
            $getTransaksi->jumlah_denda = 0;
        }

        if ($getTransaksi->update()) {
            return response()->json(['msg' => 'Transaksi terubah'], 200);
        }
        return response()->json(['msg' => 'Gagal merubah transaksi'], 500);
    }

    public function verify(Request $request)
    {
        $getTransaksi = Transaksi::where('id_transaksi', $request->input('transaksi'))->first();
        $getBuku = Buku::where('id_buku', $getTransaksi->id_buku)->first();

        $getTransaksi->id_verifikator = $request->input('verifikator');
        $getBuku->status = 'T';

        if ($getTransaksi->update() && $getBuku->update()) {
            return response()->json(['msg' => 'Transaksi selesai'], 200);
        }
        return response()->json(['msg' => 'Gagal merubah transaksi'], 500);
    }

    public function delete($id)
    {
        $getTransaksi = Transaksi::findOrFail($id);

        if ($getTransaksi->delete()) {
            return response()->json(['msg' => 'Transaksi terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus transaksi'], 500);
    }
}
