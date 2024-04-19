<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/loginregister.css">
</head>
<body>
    <div class="w-50 center border rounded px-3 py-3 mx-auto">
        <h1>Register</h1>
        <form action="{{ route('User.register') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ Session::get('name') }}"  class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" value="{{ Session::get('email') }}"  class="form-control">
            </div>
            <div class="mb-3">
                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                <input type="namalengkap" name="namalengkap" value="{{ Session::get('namalengkap') }}"  class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3 d-grid">
                <button type="submit" name="submit" class="btn btn-primary">REGISTER</button>
            </div>
        </form>
    </div>
</body>
</html>