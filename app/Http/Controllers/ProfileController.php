<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function index()
    {
        $data = Posts::get();
        $datasAlbum = Album::all();
        return view('Profile.index',compact('data', 'datasAlbum'));
    }

    public function create()
    {
        $albums = Album::all();
        $user = User::pluck('name', 'id');
        return view('Profile.uploadprofile', compact('albums', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
         'name' => 'required',
         'deskripsi' => 'required',
         'tanggaldibuat' => 'required|date',
         'cover' => 'required', // maksimal 2MB
        ]);

        $post = new Album;
        $post->name = $request->name;
        $post->deskripsi = $request->deskripsi;
        $post->tanggaldibuat = $request->tanggaldibuat;
        $post->user_id = $request->user_id;

        if ($request->hasFile('cover')) {
         $file = $request->file('cover');
         $fileName = time() . '.' . $file->getClientOriginalExtension();
         $destination = public_path('/images');
         $file->move($destination, $fileName);
         $post->cover = $fileName;
     }
     $post->save();      

     return redirect()->route('index')->with('success', 'Post created successfully.');
    }

    public function album()
    {
      $data = Album::all();
      return view('Profile.detailprofile', compact('data'));
    }
}
