<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Album;


class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('post')->get();

        return view('Home.album', compact('albums'));
    }
    public function create()
    {
        return view('albums.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggaldibuat' => 'required|date',
        ]);

        $album = new Album;
        $album->name = $request->name;
        $album->deskripsi = $request->deskripsi;
        $album->tanggaldibuat = $request->tanggaldibuat;
        $album->user_id = auth()->id();
        $album->save();

        return redirect()->route('Home.album')->with('success', 'Album created successfully.');
    }

    /**
     * Menampilkan detail sebuah album.
     */
    public function show($id)
    {
        $album = Album::findOrFail($id);
        $posts = Posts::where('album_id', $id)->get(); // Mendapatkan semua foto yang terkait dengan album
        return view('album.show', compact('album','posts'));
    }

    /**
     * Menampilkan form untuk mengedit sebuah album.
     */
    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    /**
     * Mengupdate informasi sebuah album di database.
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggaldibuat' => 'required|date',
        ]);

        $album->name = $request->name;
        $album->deskripsi = $request->deskripsi;
        $album->tanggaldibuat = $request->tanggaldibuat;
        $album->save();

        return redirect()->route('albums.index')->with('success', 'Album updated successfully.');
    }

    /**
     * Menghapus sebuah album dari database.
     */
    public function destroy($id)
{
    $album = Album::findOrFail($id);
    
    // Pastikan hanya pengguna yang memiliki izin yang dapat menghapus album
    if ($album->user_id === auth()->id()) {
        $album->delete();
        return redirect()->route('index')->with('success', 'Album deleted successfully.');
    } else {
        // Tambahkan logika untuk menangani kasus ketika pengguna tidak memiliki izin
        return redirect()->route('index')->with('error', 'You are not authorized to delete this album.');
    }
}
}
