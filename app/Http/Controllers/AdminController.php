<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    public function index() {
        $admin = Admin::all();

        return response()->json(['data' => $admin], 200);
    }

    public function add(Request $request) {
        $this->validate($request,[
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

    public function update(Request $request) {
        $getAdmin = Admin::where('id_admin',$request->input('admin'))->first();

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

    public function delete($id) {
        $getAdmin = Admin::findOrFail($id);

        if ($getAdmin->delete()) {
            return response()->json(['msg' => 'Admin terhapus'], 200);
        }
        return response()->json(['msg' => 'Gagal menghapus admin'], 500);
    }
}
