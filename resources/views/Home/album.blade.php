<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .dell{
            background-color: aquamarine
        }
        </style>
</head>
<body>
    <div class="container">
        <div class="row">
            @foreach ($albums as $album)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header">{{ $album->name }}</div>
                        <div class="card-body">
                            <p>Description: {{ $album->deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('albums.show', $album->id) }}" class="btn btn-see">Show</a>
    
                            @if ($album->user_id === auth()->id())
                            <form action="{{ route('albums.destroy', $album->id) }}" class="btn btn-default btn-xs dell" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dell"> <i class="fas fa-trash">hapus</i>
                            </button>
                            </form>
                        @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
</body>
</html>