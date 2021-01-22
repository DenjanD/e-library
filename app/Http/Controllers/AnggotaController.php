<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();

        return response()->json(['data' => $anggota]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'nama_anggota' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        $newAnggota = new Anggota([
            'username' => $request->input('username'),
            'password' => encrypt($request->input('password')),
            'nama_anggota' => $request->input('nama_anggota'),
            'telp' => $request->input('telp'),
            'alamat' => $request->input('alamat'),
            'jenis_kelamin' => $request->input('jenis_kelamin')
        ]);

        if ($newAnggota->save()) {
            return redirect('admin/anggota');
        }
        return response()->json(['msg' => 'Gagal tambah anggota'], 500);
    }

    public function update(Request $request)
    {
        $getAnggota = Anggota::where('id_anggota', $request->input('anggota'))->first();

        if ($request->input('username') != '') {
            $getAnggota->username = $request->input('username');
        }
        if ($request->input('password') != '') {
            $getAnggota->password = encrypt($request->input('password'));
        }
        if ($request->input('nama_anggota') != '') {
            $getAnggota->nama_anggota = $request->input('nama_anggota');
        }
        if ($request->input('telp') != '') {
            $getAnggota->telp = $request->input('telp');
        }
        if ($request->input('alamat') != '') {
            $getAnggota->alamat = $request->input('alamat');
        }
        if ($request->input('jenis_kelamin') != '') {
            $getAnggota->jenis_kelamin = $request->input('jenis_kelamin');
        }

        if ($getAnggota->update()) {
            return response()->json(['msg' => 'Anggota terubah'], 200);
        }
        return response()->json(['msg' => 'Gagal merubah anggota'], 500);
    }

    public function delete($id)
    {
        $getAnggota = Anggota::findOrFail($id);

        if ($getAnggota->delete()) {
            return response()->json(['msg' => 'Anggota terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus anggota'], 500);
    }
}
