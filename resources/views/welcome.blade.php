<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="row w-100">
                <div class="col-md-6 mx-auto text-center">
                    <h1 class="mb-4">Cari Buku</h1>
                    <form method="action" action="/">
                        <div class="input-group mb-3">
                            <input type="text" name="book" value="{{ $book ?? 'laravel' }}">
                            <button type="submit" class="btn btn-primary">Cari Buku</button>
                        </div>
                    </form>
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white data-table"
                        id="productTable">
                        <thead>
                            <tr class="text-center">
                                <th>Judul</th>
                                <th>Penerbit</th>
                                <th>Tanggal Terbit</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Jumlah Halaman</th>
                                <th>Cover</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($bookData))
                                <tr class="text-center align-middle">
                                    <td>{{ $bookData['judul'] }}</td>
                                    <td>{{ $bookData['penerbit'] }}</td>
                                    <td>{{ $bookData['tanggalTerbit'] }}</td>
                                    <td>{{ is_array($bookData['penulis']) ? implode(', ', $bookData['penulis']) : $bookData['penulis'] }}
                                    </td>
                                    <td>{{ is_array($bookData['kategori']) ? implode(', ', $bookData['kategori']) : $bookData['kategori'] }}
                                    </td>
                                    <td>{{ $bookData['jumlahHalaman'] }}</td>
                                    <td>
                                        @if (isset($bookData['cover']) && !empty($bookData['cover']))
                                            <img src="{{ $bookData['cover'] }}" alt="Cover Buku" width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('deskripsi', ['deskripsi' => $bookData['deskripsi']]) }}">
                                            Lihat Deskripsi
                                        </a>>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
