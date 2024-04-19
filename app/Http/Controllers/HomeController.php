<?php

namespace App\Http\Controllers;

use App\Exports\PostsExport;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Like;
use App\Models\Komentar;
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
        $data = Posts::get();
        return view('Home.gallery',compact('data'));
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

        // Respon JSON untuk mengindikasikan bahwa komentar berhasil disimpan
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
       
    
        // Cari post yang akan dihapus
        $post = Posts::find($request->postId);
    
        // Jika post ditemukan, hapus post tersebut
        if ($post) {
            // Hapus terlebih dahulu semua like yang terkait dengan post
            Like::where('post_id', $request->postId)->delete();
    
            // Hapus juga semua komentar yang terkait dengan post
            Komentar::where('post_id', $request->postId)->delete();
    
            // Hapus post itu sendiri
            $post->delete();
    
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Post not found.']);
        }
    }
}
