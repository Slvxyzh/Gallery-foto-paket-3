<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Album;
use App\Models\User;
use App\Models\Pelapor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
   public function index()
    {
        $data = Posts::get();
        $albums = Album::get();
        return view('Profile.index',compact('data', 'albums'));
    }

    public function create()
{
    $user = Auth::user();
    $albums = $user->albums()->with('post')->get(); // Pastikan menggunakan metode yang sesuai dengan relasi antara User dan Album
    return view('Profile.uploadprofile', compact('albums', 'user'));
}

    public function store(Request $request)
    {
        try{
            // Validasi input
            $request->validate([
                'name' => 'required',
                'deskripsi' => 'required',
                'tanggaldibuat' => 'required|date',
                'cover' => 'required', // maksimal 2MB
            ]);

            // Periksa apakah pengguna yang sedang masuk memiliki nama "zizah"
            // if (Auth::user()->name !== 'zizah') {
            //     return redirect()->back()->with('error', 'Only user with name "zizah" can create posts.');
            // }

            // Buat objek Album
            $post = new Album;
            $post->name = $request->name;
            $post->deskripsi = $request->deskripsi;
            $post->tanggaldibuat = $request->tanggaldibuat;
            $post->user_id = auth()->user()->id;

            // Proses unggah gambar
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('/images');
                $file->move($destination, $fileName);
                $post->cover = $fileName;
            }

            $aktivitas = "menampilkan detail foto";

            Pelapor::create([
                'user_id' => Auth::id(),
                'aktivitas' => $aktivitas,
            ]);

            // Simpan data album
            $post->save();

            // Redirect dengan pesan sukses
            return redirect()->route('profile')->with('success', 'Post created successfully.');
        }catch (\Exception $e) {
            // Log the error
            Log::error('An error occurred: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile());
            Log::error('Line: ' . $e->getLine());
            // Handle the error gracefully and provide user feedback
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan foto']);
        }
         
    }

    public function album()
    {
      $data = Album::all();
      return view('Profile.detailprofile', compact('data'));
    }
}
