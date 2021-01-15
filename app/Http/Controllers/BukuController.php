<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use App\KategoriBuku;

class BukuController extends Controller
{
    public function index() {
        $buku = Buku::all();
        
        return $buku;
        // return response()->json(['data' => $buku], 200);
    }

    public function search(Request $request) {
        $katB = KategoriBuku::all();

        $searchedData = Buku::where('judul','like','%'.$request->input('search').'%')
                        ->orWhere('penulis','like','%'.$request->input('search').'%')
                        ->orWhere('penerbit','like','%'.$request->input('search').'%')
                        ->orWhere('kategori','like','%'.$request->input('search').'%')
                        ->orWhere('status','like','%'.$request->input('search').'%')
                        ->get();

        return view('home', ['buku' => $searchedData, 'kb' => $katB]);
    }

    public function details($id) {
        $detailsData = Buku::where('id_buku',$id)->get();

        return view('detail',['detailsData' => $detailsData]);
    }

    public function add(Request $request) {
        $this->validate($request,[
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'gambar' => 'required'
        ]);

        $newBuku = new Buku([
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit' => $request->input('penerbit'),
            'kategori' => $request->input('kategori'),
            'gambar' => $request->input('gambar'),
            'status' => 'T'
        ]);

        if ($newBuku->save()) {
            return response()->json(['msg' => 'Buku nambah'], 200);
        }
        return response()->json(['msg' => 'Gagal tambah buku'], 500);
    }

    public function update(Request $request) {
        $getBuku = Buku::where('id_buku',$request->input('buku'))->first();

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
            $getBuku->kategori = $request->input('kategori');
        }
        if ($request->input('gambar') != '') {
            $getBuku->gambar = $request->input('gambar');
        }

        if ($getBuku->update()) {
            return response()->json(['msg' => 'Buku terubah'], 200);
        }
        return response()->json(['msg' => 'Gagal merubah buku'], 500);
    }

    public function delete($id) {
        $getBuku = Buku::findOrFail($id);

        if ($getBuku->delete()) {
            return response()->json(['msg' => 'Buku terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus buku'], 500);
    }
}
