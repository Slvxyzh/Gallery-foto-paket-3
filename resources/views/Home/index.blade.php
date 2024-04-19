<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>Topic Listing Bootstrap 5 Template</title> -->

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="assets/css/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/css/cardimg.css" rel="stylesheet">

        <link href="assets/css/templatemo-topic-listing.css" rel="stylesheet">      
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    
    <body id="top">

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        <!-- <i class="bi-back"></i> -->
                        {{-- <input type="hidden" name="user_id" value="{{ Auth::id() }}"> --}}
                        <span>S'gallery</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll active" href="/home">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/gallery">Gallery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/profile">Profile</a>
                            </li>
    
                            {{-- <li class="nav-item">
                                <a class="nav-link click-scroll" href="/upload">Upload</a>
                            </li> --}}
                        </ul>
                        @if (Auth::user())
                        <div class="d-none d-lg-block">
                            <a href="{{ route('logout') }}" class="navbar-icon bi-box-arrow-left smoothscroll"></a>
                        </div> 
                        @else 
                        <div class="d-none d-lg-block">
                            <a href="{{ route('User.login') }}" class="navbar-icon bi-person smoothscroll"></a>
                        </div> 
                        @endif

                    </div>
                </div>
            </nav>
            
            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <a href="{{ route('Home.posts') }}" class="btn btn-primary btn-block"><i class="bi bi-upload">Upload Image</i></a>
                            <p>Capturing Moments.</p>
                            <p>Creating Memories, Witness the Beauty in Our Gallery.</p>
                            {{-- <button type="submit" class="form-control" value="Upload Foto">Upload Foto</button> --}}
                        </div>
                        <div class="heroimg-new">
                            <img src="assets/img/Upload-cuate.svg" alt="">
                        </div>
                    </div>
                </div>
            </section>
            {{-- <a href="/upload">
                <button type="submit" class="form-control">+Upload</button>
              </a> --}}
              {{-- <a href="{{route('Home.posts')}}" class="btn btn-primary btn-block"><i class="bi bi-upload">Upload Image</i></a> --}}
        </main> 

        <div class="gallery">
            @foreach ($data as $item)
            <div class="card" data-post-id="{{ $item->id }}">
                <img src="{{ asset('images/'.$item->cover) }}" alt="Photo">
                <div class="button-group">
                    <button class="like-btn" onclick="toggleLike(this)"><i class="fas fa-heart"></i> Like <span
                            class="like-count">{{ $item->likes->count() }}</span></button>
                    <button class="comment-btn" onclick="toggleComment(this)"><i class="fas fa-comment"></i> Comment <span
                            class="comment-count">{{ $item->komentar->count() }}</span></button>
                    <button class="delete-btn" onclick="deletePost(this)" data-post-id="{{ $item->id }}"><i class="fas fa-trash"></i></button>

                    
                </div>
                <div class="comment-box" style="display: none;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <textarea class="comment-textarea" placeholder="Write your comment here..."></textarea>
                    <button class="post-comment-btn" style="margin-bottom: 10px" onclick="postComment(this)">Post</button>
                </div>
            </div>
            @endforeach
        </div>

        <script>
            function deletePost(button) {
                var postId = $(button).data('post-id');
                    
                // Konfirmasi penghapusan
                if (confirm("Are you sure you want to delete this post?")) {
                    // Kirim permintaan penghapusan ke server
                    $.ajax({
                        url: '{{ route("post.delete") }}',
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            postId: postId
                        },
                        
                        success: function(response) {
                            if (response.success) {
                                // Hapus card dari tampilan
                                $(button).closest('.card').remove();
                                alert('Post deleted successfully.');
                            } else {
                                alert('Failed to delete post: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Penanganan kesalahan saat gagal menghapus post
                            var errorMessage = "Failed to delete post: ";
                            if (xhr.responseText) {
                                // Jika respons dari server berisi pesan kesalahan
                                errorMessage += xhr.responseText;
                            } else {
                                // Jika tidak ada respons dari server
                                errorMessage += status + ": " + error;
                            }
                            alert(errorMessage);
                        }
                    });
                }
            }
        </script>
        
        <!-- JAVASCRIPT FILES -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.sticky.js"></script>
        <script src="assets/js/click-scroll.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/komentar.js"></script>

    </body>
</html>
