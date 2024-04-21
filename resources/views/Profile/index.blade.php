<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instagram Profile Layout</title>
  <link href="assets/css/profile.css" rel="stylesheet">
  <style>
      .dell{
            background-color: aquamarine
        }
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
  <div style="margin-top: 20px;">
    <button class="btn btn-primary" style="background-color: #85a4c5; border: none; border-radius: 8px; padding: 10px 20px; font-size: 16px; color: white;" onclick="window.location='{{ route('home') }}';">Back to Home</button>
</div>

</div>
  <div class="container">
    <div class="profile-header">
      <div class="profile-image">
        <img src="assets/img/profile.png" alt="Profile Picture">
      </div>
      <div class="profile-info">
        @if(Auth::check())
          <h5 style="color: #859aa0; font-size: 20px;"> {{ Auth::user()->name }}</h5>
          @else
          <p style="color: #9c9c9c;">Welcome, Guest</p>
          @endif
        <p>Bio: hai manteman</p>
        {{-- <ul class="profile-stats">
          <li><strong>100</strong> Posts</li>
          <li><strong>200</strong> Followers</li>
          <li><strong>300</strong> Following</li>
        </ul> --}}
      </div>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
      <a href="{{ route('Profile.uploadprofile') }}" class="btn btn-primary btn-block upload-button">
        <i class="bi bi-upload"></i>+Upload
    </a>    </form>
    
    {{-- <div class="container">
      <div class="gallery">
          @foreach ($datasAlbum as $item)
          <div class="card" data-post-id="{{ $item->id }}">
            <a href="{{ route('Home.album')}}"><img src="{{ asset('images/'.$item->cover) }}" alt="Photo" style="width: 200px; height: 200px;"></a>  
              <!-- Loop untuk menampilkan semua komentar -->
          </div>
          @endforeach
      </div>
      </div> --}}

<div class="gallery">
  @foreach ($albums as $album)
      @if ($album->user_id === auth()->id())
          <div class="card custom-card {{ $album->category }}">
              <a href="{{ route('albums.show', $album->id) }}">
                  {{-- <img src="{{ asset('images/'.$album->cover) }}" class="card-img-top" alt="{{ $album->name }}"> --}}
              </a>
              <div class="card-body">
                  <a href="{{ route('albums.show', $album->id) }}">
                      <h5 class="card-title text-center">{{ $album->name }}</h5>
                  </a>
                  <p class="card-text">{{ $album->deskripsi }}</p>
              </div>
          </div>
      @endif
  @endforeach
</div>



<script>
  document.addEventListener("DOMContentLoaded", function () {
      const buttons = document.querySelectorAll('.controls .buttons');
      const galleryItems = document.querySelectorAll('.gallery .custom-card');

      buttons.forEach(button => {
          button.addEventListener('click', function () {
              buttons.forEach(btn => btn.classList.remove('active'));
              this.classList.add('active');

              const filter = this.getAttribute('data-filter');

              galleryItems.forEach(item => {
                  item.style.display = 'none';
                  if (item.classList.contains(filter) || filter === 'all') {
                      item.style.display = 'block';
                  }
              });
          });
      });
  });
</script>




    <script>
        function showPhotoDetails(imageSrc, altText, albumName) {
        var modal = document.getElementById('photoModal');
        var modalImg = document.getElementById("modalPhoto");
        var captionText = document.getElementById("caption");
        var albumCaption = document.getElementById("albumCaption");
        modal.style.display = "block";
        modalImg.src = imageSrc;
        captionText.innerHTML = altText;
        albumCaption.innerHTML = albumName;
    }
    </script>

</body>
</html>