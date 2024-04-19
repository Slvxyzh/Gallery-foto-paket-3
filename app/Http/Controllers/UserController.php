<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function index()
    {
        return view('User.login');
    }

    public function login(Request $request)
    {
        Session::flash('email', $request->input('email'));
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/home')->with('success', 'Berhasil login');
        } else {
            return redirect()->back()->withErrors('Username dan password yang dimasukkan tidak sesuai');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('User')->with('success', 'Berhasil logout');
    }

    public function register()
    {
        return view('User.register');
    }
    public function create(Request $request)
    {
        Session::flash('name', $request->input('name'));
        Session::flash('email', $request->input('email'));

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'namalengkap' => 'required|string|max:255',
            'password' => 'required|min:8'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email yang dimasukkan tidak valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan email yang lain',
            'namalengkap.required' => 'Nama Lengkap wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Minimum password 8 karakter'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'namalengkap' => $request->namalengkap,
            'password' => Hash::make($request->password)
        ];
        User::create($data);

        return redirect('User')->with('success', 'Berhasil mendaftar. Silahkan login.');
    }
}

