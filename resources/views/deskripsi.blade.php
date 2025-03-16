<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>desc</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    <div class="container mt-5">
        <h1 style="font-weight: bolder">Deskripsi Buku </h1>
        <hr style="border-width:  5px">
            <h4>{{ $deskripsi }}</h3>
        <br>
        <a href="{{ url('/') }}" class="btn btn-primary" style="font-size: 150%"> Kembali</a>
    </div>
    @vite('resources/sass/app.scss')
</body>

</html>
