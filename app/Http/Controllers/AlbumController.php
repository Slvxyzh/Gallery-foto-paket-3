<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Album;


class AlbumController extends Controller
{
    public function index()
    {
        $data = Posts::get();

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

        return redirect()->route('albums.index')->with('success', 'Album created successfully.');
    }

    /**
     * Menampilkan detail sebuah album.
     */
    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
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
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
    }
}
