<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instagram Profile Layout</title>
  <link href="assets/css/profile.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="profile-header">
      <div class="profile-image">
        <img src="assets/img/profile.png" alt="Profile Picture">
      </div>
      <div class="profile-info">
        <h1>@username</h1>
        <p>Bio: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia vehicula ipsum nec tristique.</p>
        <ul class="profile-stats">
          <li><strong>100</strong> Posts</li>
          <li><strong>200</strong> Followers</li>
          <li><strong>300</strong> Following</li>
        </ul>
      </div>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
        <a href="{{ route('Profile.uploadprofile') }}" class="btn btn-primary btn-block" style="margin-top: 25px; background-color: #9baec2;" ><i class="bi bi-upload">+Upload</i></a>
    </form>
    
    <div class="container">
      <div class="gallery">
          @foreach ($datasAlbum as $item)
          <div class="card" data-post-id="{{ $item->id }}">
            <a href="albumFoto"><img src="{{ asset('images/'.$item->cover) }}" alt="Photo" style="width: 200px; height: 200px;"></a>  
              <!-- Loop untuk menampilkan semua komentar -->
          </div>
          @endforeach
      </div>
      </div>

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