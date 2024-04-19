<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Album;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Posts::all(); 
        return view('Home.index', compact('posts'));
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
            'cover' => 'required', // maksimal 2MB
            'album_id' => 'required|exists:albums,id',
        ]);
        

        $post = new Posts;
        $post->name = $request->name;
        $post->deskripsi = $request->deskripsi;
        $post->tanggaldibuat = $request->tanggaldibuat;
        $post->album_id = $request->album_id;
        $post->user_id = auth()->id();

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
