<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instagram Profile Layout</title>
  <link href="{{asset('assets/css/profile.css')}}" rel="stylesheet">
</head>
<body>
  
    <div id="photoModal" class="modal">
        <span class="close" onclick="closePhotoModal()">&times;</span>
        <img class="modal-content" id="modalPhoto">
        <div id="caption"></div>
        <div id="albumCaption"></div>
    </div>

    @foreach ($data as $item)
       <img src="{{ asset('images/'.$item->cover) }}" alt="Photo" style="width: 200px; height: 200px; margin-top: 80px ">
    @endforeach


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
