<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/Post.css')}}">
</head>
<body>
  <div class="container">
    <h3 class="mt-4">Upload Image</h3>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
          <label for="name">Judul:</label>
          <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan judul">
      </div>
      <div class="form-group">
          <label for="deskripsi">Deskripsi:</label>
          <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi"></textarea>
      </div>
      <div class="form-group">
          <label for="tanggaldibuat">Tanggal Dibuat:</label>
          <input type="date" class="form-control" name="tanggaldibuat" id="tanggaldibuat">
      </div>
      <div class="form-group">
          <label for="cover">Cover:</label>
          <input type="file" class="form-control-file" name="cover" id="cover">
      </div>
      <div class="form-group">
        <label for="album_id">Album:</label>
        <select name="album_id" id="album_id" class="form-control">
            @foreach($albums as $album)
                @if($album->user_id == auth()->id())
                    <option value="{{ $album->id }}">{{ $album->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    
    
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
