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

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
                            <a class="nav-link click-scroll" href="/home">Home</a>
                        </li>

                        <li class="nav-item dropdown" style="margin-top: -3px">
                            <a class="nav-link dropdown-toggle btn btn-primary btn-block" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-upload"></i> Upload
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('Home.posts') }}">Upload Foto</a></li>
                                <li><a class="dropdown-item" href="{{ route('Profile.uploadprofile') }}">Upload Album</a></li>
                            </ul>
                        </li> 

                        <li class="nav-item">
                                <a class="nav-link click-scroll" href="/profile">Profile</a>
                            </li>
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


        {{-- <a href="/upload">
                <button type="submit" class="form-control">+Upload</button>
              </a> --}}
        {{-- <a href="{{route('Home.posts')}}" class="btn btn-primary btn-block"><i class="bi bi-upload">Upload Image</i></a> --}}
    </main>
    <br><br><br><br>
    <div class="container">
        {{-- <a href="{{ route('export') }}" class="btn btn-primary btn-block"><i class="bi bi-upload">Pelaporan</i></a> --}}
        <div class="gallery">
            @foreach ($posts as $item)
            <div class="card" data-post-id="{{ $item->id }}">
                <img src="{{ asset('images/'.$item->cover) }}" alt="Photo">
                <div class="">
                    &nbsp;&nbsp;
                    <i class="fas fa-heart"></i> <span class="like-count">{{ $item->likes->count() }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <i class="fas fa-comment"></i> <span class="comment-count">{{ $item->komentar->count() }}</span>
                </div>
                <!-- Loop untuk menampilkan semua komentar -->
                <hr>
                <p style="margin-left: 15px;">Semua Komentar</p>
                <div class="comments ml-3" style="margin-left: 15px;">
                    @foreach ($item->komentar as $comment)
                    <div class="comment d-flex align-items-center justify-content-between">
                        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->isikomentar }}</p>
                        <button class="delete-comment-btn" onclick="deleteComment(this)" data-comment-id="{{ $comment->id }}">
                            <i class="fas fa-trash" style="border: none;"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="comment-box" style="display: none;">
                    <textarea class="comment-textarea" placeholder="Write your comment here..."></textarea>
                    <button class="post-comment-btn" onclick="postComment(this)">Post</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function deleteComment(button) {
        if (confirm("Are you sure you want to delete this comment?")) {
            var commentId = button.getAttribute('data-comment-id');

            $.ajax({
                url: '/komentar/delete/' + commentId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hapus komentar dari DOM jika penghapusan berhasil
                    $(button).closest('.comment').remove();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Error deleting comment!');
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