<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriBukuController;

class LoginController extends Controller
{
    protected $buku;
    protected $kb;

    public function __construct()
    {
        $this->buku = new BukuController();
        $this->kb = new KategoriBukuController();
    }

    public function auth(Request $request)
    {
        if ($request->session()->has('logged')) {
            return view('home');
        }

        $this->validate($request, [
            'uname' => 'required',
            'pass' => 'required'
        ]);

        $credentials = Anggota::where('username', $request->input('uname'))->first();
        if (!$credentials) {
            return response()->json(['msg' => 'Username atau Password salah!'], 500);
        }
        $checkPass = decrypt($credentials->password);

        if ($checkPass == $request->input('pass')) {
            $request->session()->put('logged', $credentials->id_anggota);

            return redirect('home');
        } else {
            return response()->json(['msg' => 'An Error Occured']);
        }
    }

    public function home()
    {
        $dataBuku = $this->buku->index();
        $dataKb = $this->kb->index();

        return view('home', ['buku' => $dataBuku, 'kb' => $dataKb]);
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('logged')) {
            $request->session()->forget('logged');

            return redirect('/');
        } else {
            return response()->json(['msg' => 'No user logon!', 404]);
        }
    }
}
