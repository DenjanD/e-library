<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Anggota;
use App\KategoriBuku;
use App\Buku;
use App\Transaksi;
use PDF;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->session()->has('administrator')) {
            return view('admin/dashboard');
        }

        $this->validate($request, [
            'id' => 'required',
            'password' => 'required'
        ]);

        $credentials = Admin::where('id_admin', $request->input('id'))->first();
        if (!$credentials) {
            return redirect('veryadmin')->with(['warning' => 'Id tidak ditemukan!']);
        }
        $checkPass = decrypt($credentials->password);

        if ($checkPass == $request->input('password')) {
            $request->session()->put('administrator', $credentials->id_admin);
            $request->session()->put('name', $credentials->nama_admin);

            return redirect('admin/dashboard');
        } else {
            return redirect('veryadmin')->with(['warning' => 'Password salah! Silakan coba lagi']);
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $request->session()->forget('administrator');

            return redirect('veryadmin');
        } else {
            return response()->json(['msg' => 'No user logon'], 404);
        }
    }

    public function dashboard(Request $request)
    {
        if ($request->session()->has('administrator')) {
            return view('admin/dashboard');
        } else {
            return redirect('/veryadmin');
        }
    }

    public function katb(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataKat = KategoriBuku::all();
            return view('admin/datakat', ['dataKat' => $dataKat]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function katbChart(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $labelKat = Transaksi::select(DB::raw('nama as label'))
                ->join('bukus', 'transaksis.id_buku', '=', 'bukus.id_buku')
                ->join('kategori_bukus', 'id_kategori', '=', 'kategori')
                ->groupBy('nama')
                ->get();

            $valueKat = Transaksi::select(DB::raw('count("nama") as value'))
                ->join('bukus', 'transaksis.id_buku', '=', 'bukus.id_buku')
                ->join('kategori_bukus', 'id_kategori', '=', 'kategori')
                ->groupBy('nama')
                ->get();

            return response()->json(['labelKat' => $labelKat, 'valueKat' => $valueKat]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function transchart(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $valueTrans = Transaksi::select(DB::raw('count(*) as value'))
                ->groupBy(DB::raw('MONTH(tanggal_kembali)'))
                ->get();

            return response()->json(['valueTrans' => $valueTrans]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function katbSpec($id, Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataKat = KategoriBuku::where('id_kategori', $id)->get();
            return response()->json(['detailData' => $dataKat], 200);
        } else {
            return response()->json(['msg' => 'No user logon!'], 404);
        }
    }

    public function buku(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataBuku = Buku::select('bukus.*', 'kategori_bukus.nama as kategoribuku')->join('kategori_bukus', 'id_kategori', '=', 'kategori')->get();
            $dataKat = KategoriBuku::all();
            return view('admin/databuku', ['dataBuku' => $dataBuku, 'dataKat' => $dataKat]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function bukuSpec($id, Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataBuku = Buku::select('bukus.*', 'kategori_bukus.nama as kategoribuku')->join('kategori_bukus', 'id_kategori', '=', 'kategori')->where('id_buku', $id)->get();
            return response()->json(['detailData' => $dataBuku], 200);
        } else {
            return response()->json(['msg' => 'No user logon!'], 404);
        }
    }

    public function anggota(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataAng = Anggota::all();
            return view('admin/dataang', ['dataAng' => $dataAng]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function anggotaSpec($id, Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataAnggota = Anggota::where('id_anggota', $id)->get();
            return response()->json(['detailData' => $dataAnggota], 200);
        } else {
            return response()->json(['msg' => 'No user logon!'], 404);
        }
    }

    public function transaksi(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataTra = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->leftJoin('admins', 'id_admin', '=', 'id_verifikator')
                ->get();
            return view('admin/transaksi', ['dataTra' => $dataTra]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function transaksiSpec($id, Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataTra = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->leftJoin('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_transaksi', $id)
                ->get();
            return response()->json(['detailData' => $dataTra], 200);
        } else {
            return redirect('veryadmin');
        }
    }

    public function transaksiVer(Request $request)
    {
        $getTrans = Transaksi::where('id_transaksi', $request->input('idVerify'))->first();
        $getTrans->id_verifikator = $request->session()->get('administrator');

        if ($getTrans->update()) {
            return redirect('admin/transaksi');
        } else {
            return response()->json(['msg' => 'Verifikasi gagal!'], 404);
        }
    }

    public function laporan(Request $request)
    {
        if ($request->session()->has('administrator')) {
            $dataPem = Anggota::all();
            $dataBuk = Buku::all();
            $dataAdm = Admin::all();
            return view('admin/laporan', ['dataPem' => $dataPem, 'dataBuk' => $dataBuk, 'dataAdm' => $dataAdm]);
        } else {
            return redirect('veryadmin');
        }
    }

    public function export(Request $request)
    {
        if ($request->input('peminjam') == '--- Pilih Peminjam ---') {
            $peminjam = '';
        }
        if ($request->input('buku') == '--- Pilih Buku ---') {
            $buku = '';
        }
        if ($request->input('verifikator') == '--- Pilih Verifikator ---') {
            $verifikator = '';
        }
        $tglPinjam = '';
        $tglKembali = '';
        $isDenda = '';
        $isNotDenda = '';

        if ($request->input('peminjam') != '--- Pilih Peminjam ---') {
            $getPeminjam = Anggota::where('nama_anggota', $request->input('peminjam'))->first();
            $peminjam = $getPeminjam->id_anggota;
        }
        if ($request->input('buku') != '--- Pilih Buku ---') {
            $getBuku = Buku::where('judul', $request->input('buku'))->first();
            $buku = $getBuku->id_buku;
        }
        if ($request->input('tglPinjam') != '') {
            $tglPinjam = $request->input('tglPinjam');
        }
        if ($request->input('tglKembali') != '') {
            $tglKembali = $request->input('tglKembali');
        }
        if ($request->input('verifikator') != '--- Pilih Verifikator ---') {
            $getVerifikator = Admin::where('nama_admin', $request->input('verifikator'))->first();
            $verifikator = $getVerifikator->id_admin;
        }
        if ($request->input('denda') != '') {
            $isDenda = $request->input('denda');
        }
        if ($request->input('tidakDenda') != '') {
            $isNotDenda = $request->input('tidakDenda');
        }

        if ($isDenda != '' && $isNotDenda == '' && $tglPinjam != ''  && $tglKembali != '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '>', '0')
                ->whereDate('tanggal_pinjam', '>=', $tglPinjam)
                ->whereDate('tanggal_kembali', '<=', $tglKembali)
                ->get();
        } else if ($isDenda == '' && $isNotDenda != '' && $tglPinjam != ''  && $tglKembali != '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '=', '0')
                ->whereDate('tanggal_pinjam', '>=', $tglPinjam)
                ->whereDate('tanggal_kembali', '<=', $tglKembali)
                ->get();
        } else if ($isDenda == '' && $isNotDenda == '' && $tglPinjam != ''  && $tglKembali != '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->whereDate('tanggal_pinjam', '>=', $tglPinjam)
                ->whereDate('tanggal_kembali', '<=', $tglKembali)
                ->get();
        } else if ($isDenda != '' && $isNotDenda == '' && $tglPinjam != ''  && $tglKembali == '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '>', '0')
                ->whereDate('tanggal_pinjam', '<=', $tglPinjam)
                ->get();
        } else if ($isDenda != '' && $isNotDenda == '' && $tglPinjam == ''  && $tglKembali != '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '>', '0')
                ->whereDate('tanggal_kembali', '<=', $tglKembali)
                ->get();
        } else if ($isDenda != '' && $isNotDenda == '' && $tglPinjam == ''  && $tglKembali == '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '>', '0')
                ->get();
        } else if ($isDenda == '' && $isNotDenda != '' && $tglPinjam != ''  && $tglKembali == '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '=', '0')
                ->whereDate('tanggal_pinjam', '<=', $tglPinjam)
                ->get();
        } else if ($isDenda == '' && $isNotDenda != '' && $tglPinjam == ''  && $tglKembali != '') {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->where('jumlah_denda', '=', '0')
                ->whereDate('tanggal_kembali', '<=', $tglKembali)
                ->get();
        } else {
            $peminjaman = Transaksi::select('transaksis.*', 'nama_anggota', 'judul', 'nama_admin')
                ->join('anggotas', 'id_peminjam', '=', 'id_anggota')
                ->join('bukus', 'bukus.id_buku', '=', 'transaksis.id_buku')
                ->join('admins', 'id_admin', '=', 'id_verifikator')
                ->where('id_peminjam', 'like', '%' . $peminjam . '%')
                ->where('transaksis.id_buku', 'like', '%' . $buku . '%')
                ->where('id_verifikator', 'like', '%' . $verifikator . '%')
                ->get();
        }

        if ($request->input('radioExport') == 'pdf') {
            $pdf = PDF::loadview('admin/peminjamanPdf', ['peminjaman' => $peminjaman]);
            return $pdf->download('laporan-peminjaman.pdf');
        } else if ($request->input('radioExport') == 'excel') {
            return Excel::download(new TransaksiExport, 'laporan-peminjaman.xlsx');
        } else {
            return response()->json(['msg' => 'pilih format']);
        }
    }

    public function index()
    {
        $admin = Admin::all();

        return response()->json(['data' => $admin], 200);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'password' => 'required',
        ]);

        $newAdmin = new Admin([
            'id_admin' => $request->input('id_admin'),
            'nama_admin' => $request->input('nama_admin'),
            'password' => encrypt($request->input('password')),
        ]);

        if ($newAdmin->save()) {
            return response()->json(['msg' => 'Admin nambah'], 200);
        }
        return response()->json(['msg' => 'Gagal tambah admin'], 500);
    }

    public function update(Request $request)
    {
        $getAdmin = Admin::where('id_admin', $request->input('admin'))->first();

        if ($request->input('nama_admin') != '') {
            $getAdmin->nama_admin = $request->input('nama_admin');
        }
        if ($request->input('password') != '') {
            $getAdmin->password = encrypt($request->input('password'));
        }

        if ($getAdmin->save()) {
            return response()->json(['msg' => 'Admin terubah'], 200);
        }
        return response()->json(['msg' => 'Gagal merubah anggota'], 500);
    }

    public function delete($id)
    {
        $getAdmin = Admin::findOrFail($id);

        if ($getAdmin->delete()) {
            return response()->json(['msg' => 'Admin terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus admin'], 500);
    }
}
