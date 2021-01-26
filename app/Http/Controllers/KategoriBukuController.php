<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriBuku;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kb = KategoriBuku::all();

        return $kb;
        // return response()->json(['data' => $kb]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);

        $newKb = new KategoriBuku([
            'nama' => $request->input('nama')
        ]);

        if ($newKb->save()) {
            return redirect('admin/katb')->with(['success' => 'Kategori buku berhasil ditambahkan!']);
        }
        return response()->json(['msg' => 'Gagal tambah Kategori Buku'], 500);
    }

    public function update(Request $request)
    {
        $getKb = KategoriBuku::where('id_kategori', $request->input('kategori'))->first();

        if ($request->input('nama') != '') {
            $getKb->nama = $request->input('nama');
        }

        if ($getKb->update()) {
            return redirect('admin/katb')->with(['success2' => 'Kategori buku berhasil diubah!']);
        }
        return response()->json(['msg' => 'Gagal merubah Kategori Buku'], 500);
    }

    public function delete($id)
    {
        $getKb = KategoriBuku::findOrFail($id);

        if ($getKb->delete()) {
            return response()->json(['msg' => 'Kategori Buku terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus Kategori Buku'], 500);
    }
}
