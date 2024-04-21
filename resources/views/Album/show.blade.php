<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #heroprofile .container-text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #heroprofile p {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('profile') }}" class="btn btn-primary mb-3" style="margin-top: 20px; margin-right: 150px; background-color:rgb(128, 135, 173); border: none;">Back to Profile</a>
                @if (!is_null($posts) && $posts->isNotEmpty())
                    <div class="container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-md-4 mb-3">
                                    <div class="card" style="margin-top: 20px;"> <!-- Tambahkan margin-top di sini -->
                                        <div class="card-body">
                                            <img src="{{ asset('images/' . $post->cover) }}" alt="{{ $post->name }}" class="img-fluid">
                                            <div class="text-center">
                                                <p style="font-weight: 500; font-size: 20px;">{{ $post->name }}</p>
                                                <p style="font-size: 18px;">{{ $post->deskripsi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p>Tidak ada foto yang tersedia saat ini.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
