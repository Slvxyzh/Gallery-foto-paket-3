<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Exports\PostsExport;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Like;
use App\Models\Komentar;
use App\Models\Album;
use App\Models\Pelapor;
use Maatwebsite\Excel\Facades\Excel;
class HomeController extends Controller
{
    public function index()
    {
        if(auth()->user()){
            $data = Posts::get();
            return view('Home.index',compact('data'));
        }else{
            return redirect('User');
        }
    }
    
    public function gallery()
    {
        $albums = Album::get();
        $posts = Posts::all(); // Mengambil semua foto dari semua album tanpa filter berdasarkan ID pengguna
        return view('Home.gallery', ['posts' => $posts, 'albums' => $albums]);
    }

    // public function profile()
    // {
    //     $data = Posts::get();
    //     return view('Home.profile',compact('data'));
    // }

    public function export()
    {
        $posts = Posts::with('album', 'likes', 'komentar')->get()->map(function ($post) {
            return [
                'nomor' => $post->id,
                'nama' => $post->name,
                'cover' => $post->cover,
                'album' => $post->album->name,
                'tanggaldibuat' => $post->tanggaldibuat,
                'totallike' => $post->likes->count(),
                'totalkomentar' => $post->komentar->count()
            ];
        });

        return Excel::download(new PostsExport($posts), 'posts.xlsx');
    }

    // Fungsi untuk menyimpan data like ke dalam basis data
    public function storeLike(Request $request)
    {
        // Validasi input
        $request->validate([
            'postId' => 'required|exists:posts,id',
        ]);

        // Simpan data like ke dalam basis data
        $like = new Like();
        $like->post_id = $request->postId;
        $like->user_id = auth()->id(); // Anda bisa mengganti ini sesuai dengan cara Anda mengelola autentikasi
        $like->tanggallike = now(); // Tanggal dan waktu saat ini
        $like->save();

        return response()->json(['success' => true]);
    }

    public function checkLikeStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'postId' => 'required',
        ]);

        // Periksa apakah user_id sudah melakukan like pada post_id
        $likeExists = Like::where('post_id', $request->postId)
                          ->where('user_id', auth()->id())
                          ->exists();

        return response()->json(['liked' => $likeExists]);
    }

    public function unlike(Request $request)
    {
        // Validasi input
        $request->validate([
            'postId' => 'required',
        ]);

        // Cari like yang sesuai berdasarkan post_id dan user_id
        $like = Like::where('post_id', $request->postId)
                    ->where('user_id', auth()->id())
                    ->first();

        // Jika like ditemukan, hapus like tersebut
        if ($like) {
            $like->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Like not found.']);
        }
    }

    public function storeKomentar(Request $request)
    {
        // Validasi input
        $request->validate([
            'postId' => 'required',
            'commentText' => 'required',
        ]);

        // Simpan komentar ke dalam database
        $komentar = new Komentar();
        $komentar->post_id = $request->postId;
        $komentar->user_id = auth()->id();
        $komentar->isikomentar = $request->commentText;
        $komentar->tanggalkomentar = now(); // Tanggal komentar saat ini
        $komentar->save();

        $aktivitas = "menampilkan detail foto";

        Pelapor::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
        ]);
        // Respon JSON untuk mengindikasikan bahwa komentar berhasil disimpan
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
         $comment = Komentar::findOrFail($id);
         $comment->delete();

         return response()->json(['success' => true]);
    }
    
}
