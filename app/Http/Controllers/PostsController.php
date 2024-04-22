<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Posts;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $albums = Album::where('user_id', auth()->id())->get(); // Hanya ambil album yang dimiliki oleh pengguna saat ini
     return view('nama_view', compact('albums'));
    }

    public function create()
    {
        $albums = Album::all();
        return view('Home.posts', compact('albums'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'deskripsi' => 'required',
        'tanggaldibuat' => 'required|date',
        'cover' => 'required|image|max:2048', // maksimal 2MB
        'album_id' => [
            'required',
            'exists:albums,id', // pastikan album_id yang dipilih ada di tabel albums
            // aturan khusus untuk memastikan album_id milik pengguna saat ini
            function ($attribute, $value, $fail) {
                $album = Album::find($value);
                if (!$album || $album->user_id != auth()->id()) {
                    $fail('The selected album is invalid.');
                }
            },
        ],
    ]);
    

    $post = new Posts;
    $post->name = $request->name;
    $post->deskripsi = $request->deskripsi;
    $post->tanggaldibuat = $request->tanggaldibuat;
    $post->album_id = $request->album_id; // pastikan album_id yang dipilih adalah milik pengguna saat ini
    $post->user_id = auth()->id();

    $aktivitas = "menampilkan detail foto";

        Pelapor::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
        ]);

    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('/images');
        $file->move($destination, $fileName);
        $post->cover = $fileName;
    }
    $post->save();

    return redirect()->route('home')->with('success', 'Post created successfully.');
    }
}
