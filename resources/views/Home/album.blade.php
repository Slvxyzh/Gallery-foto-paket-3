<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="input">
        <label for="album">Album:</label>
        <select name="album_id" id="album">
            @foreach($albums as $album)
                <option value="{{ $album->id }}">{{ $album->name }}</option>
            @endforeach
        </select>
</body>
</html>