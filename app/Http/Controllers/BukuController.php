<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use App\KategoriBuku;
use App\Transaksi;
use File;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();

        return $buku;
        // return response()->json(['data' => $buku], 200);
    }

    public function search(Request $request)
    {
        $katB = KategoriBuku::all();

        $searchedData = Buku::where('judul', 'like', '%' . $request->input('search') . '%')
            ->orWhere('penulis', 'like', '%' . $request->input('search') . '%')
            ->orWhere('penerbit', 'like', '%' . $request->input('search') . '%')
            ->orWhere('kategori', 'like', '%' . $request->input('search') . '%')
            ->orWhere('status', 'like', '%' . $request->input('search') . '%')
            ->get();

        return view('home', ['buku' => $searchedData, 'kb' => $katB]);
    }

    public function details($id)
    {
        // $detailsData = Buku::where('id_buku',$id)->get();
        $detailsData = Buku::where('id_buku', $id)->join('kategori_bukus', 'kategori', '=', 'id_kategori')
            ->select('bukus.*', 'kategori_bukus.nama as kategori')
            ->get();

        $reviewsData = Transaksi::where('id_buku', $id)->join('anggotas', 'id_peminjam', '=', 'id_anggota')
            ->select('transaksis.komentar', 'anggotas.nama_anggota as peminjam', 'transaksis.tanggal_kembali')
            ->get();

        return view('detail', ['detailsData' => $detailsData, 'reviews' => $reviewsData]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'sinopsis' => 'required',
            'gambar' => 'required'
        ]);

        $filePhoto = $request->file('gambar');

        $getKatNew = KategoriBuku::where('nama', $request->input('kategori'))->get();

        foreach ($getKatNew as $g) {
            $katNew = $g->id_kategori;
        }

        $newBuku = new Buku([
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit' => $request->input('penerbit'),
            'kategori' => $katNew,
            'sinopsis' => $request->input('sinopsis'),
            'gambar' => $filePhoto->getClientOriginalName(),
            'status' => 'T'
        ]);

        if ($newBuku->save()) {
            $filePhoto->move(base_path('public/bukuPhotos'), $filePhoto->getClientOriginalName());
            return redirect('admin/buku')->with(['success' => 'Data buku berhasil ditambahkan']);
        }
        return response()->json(['msg' => 'Gagal tambah buku'], 500);
    }

    public function update(Request $request)
    {
        $getBuku = Buku::where('id_buku', $request->input('buku'))->first();
        $getKatB = KategoriBuku::where('nama', $request->input('kategori'))->first();
        $oldPict = $getBuku->gambar;
        $newPhoto = $request->file('gambar');
        if ($request->input('judul') != '') {
            $getBuku->judul = $request->input('judul');
        }
        if ($request->input('penulis') != '') {
            $getBuku->penulis = $request->input('penulis');
        }
        if ($request->input('penerbit') != '') {
            $getBuku->penerbit = $request->input('penerbit');
        }
        if ($request->input('kategori') != '') {
            $getBuku->kategori = $getKatB->id_kategori;
        }
        if ($request->input('sinopsis') != '') {
            $getBuku->sinopsis = $request->input('sinopsis');
        }
        if ($request->file('gambar') != '') {
            $getBuku->gambar = $newPhoto->getClientOriginalName();
        }
        if ($request->input('status') != '') {
            if ($request->input('status') == 'Tersedia') {
                $getBuku->status = 'T';
            }
            if ($request->input('status') == 'Dipinjam') {
                $getBuku->status = 'D';
            }
            if ($request->input('status') == 'Kosong') {
                $getBuku->status = 'K';
            }
        }

        if ($getBuku->update()) {
            if ($newPhoto != '' && $oldPict != '') {
                File::delete(base_path('public/bukuPhotos/' . $oldPict));
                $newPhoto->move(base_path('public/bukuPhotos'), $getBuku->gambar);
            }
            return redirect('admin/buku')->with(['success' => 'Data buku berhasil diubah']);;
        }
        return response()->json(['msg' => 'Gagal merubah buku'], 500);
    }

    public function delete($id)
    {
        $getBuku = Buku::findOrFail($id);

        if ($getBuku->delete()) {
            File::delete(base_path('public/bukuPhotos/' . $getBuku->gambar));
            return response()->json(['msg' => 'Buku terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus buku'], 500);
    }
}
