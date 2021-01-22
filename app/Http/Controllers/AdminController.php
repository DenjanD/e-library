<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Anggota;
use App\KategoriBuku;
use App\Buku;

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
            return response()->json(['msg' => 'Id atau Password salah!'], 500);
        }
        $checkPass = decrypt($credentials->password);

        if ($checkPass == $request->input('password')) {
            $request->session()->put('administrator', $credentials->id_admin);
            $request->session()->put('name', $credentials->nama_admin);

            return redirect('admin/dashboard');
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
