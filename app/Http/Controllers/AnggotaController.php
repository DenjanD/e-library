<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use File;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();

        return response()->json(['data' => $anggota]);
    }

    public function profile(Request $request)
    {
        $anggota = Anggota::where('id_anggota', $request->session()->get('logged'))->get();

        return view('profile', ['profileData' => $anggota]);
    }

    public function checkPass(Request $request)
    {
        $passAnggota = Anggota::where('id_anggota', $request->session()->get('logged'))->first();
        $pass = decrypt($passAnggota->password);

        return response()->json(['pass' => $pass]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'nama_anggota' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required'
        ]);

        if ($request->input('jenis_kelamin') == 'Laki-Laki') {
            $jk = 'L';
        } else if ($request->input('jenis_kelamin') == 'Perempuan') {
            $jk = 'P';
        } else {
            return response()->json(['msg' => 'Jenis kelamin belum diisi'], 404);
        }

        $newAnggota = new Anggota([
            'username' => $request->input('username'),
            'password' => encrypt($request->input('password')),
            'nama_anggota' => $request->input('nama_anggota'),
            'telp' => $request->input('telp'),
            'alamat' => $request->input('alamat'),
            'jenis_kelamin' => $jk,
            'email' => $request->input('email'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'foto' => ''
        ]);

        if ($newAnggota->save()) {
            return redirect('/')->with(['success' => 'Akun berhasil dibuat, silakan login untuk melanjutkan']);
        }
        return response()->json(['msg' => 'Gagal tambah anggota'], 500);
    }

    public function update(Request $request)
    {
        $getAnggota = Anggota::where('id_anggota', $request->session()->get('logged'))->first();
        $oldPict = $getAnggota->foto;
        $newPict = $request->file('foto');

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
        if ($request->input('email') != '') {
            $getAnggota->email = $request->input('email');
        }
        if ($request->input('tgl_lahir') != '') {
            $getAnggota->tgl_lahir = $request->input('tgl_lahir');
        }
        if ($newPict != '') {
            if ($oldPict == '') {
                $getAnggota->foto = $newPict->getClientOriginalName();
            } else {
                File::delete(base_path('public/userPhotos/' . $oldPict));
                $getAnggota->foto = $newPict->getClientOriginalName();
            }
        }
        if ($request->input('jenis_kelamin') != '') {
            $getAnggota->jenis_kelamin = $request->input('jenis_kelamin');
        }

        if ($getAnggota->update()) {
            if ($newPict != '') {
                $newPict->move(base_path('public/userPhotos'), $getAnggota->foto);
            }
            return redirect('profile')->with(['success' => 'Profil berhasil diubah!']);
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
