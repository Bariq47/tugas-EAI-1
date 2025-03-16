<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $book = $request->query('book', 'harry potter');

        if ($book) {
            $apiKey = env('GOOGLE_BOOKS_API_KEY');
            $url = "https://www.googleapis.com/books/v1/volumes?q={$book}&maxResults=20&key={$apiKey}";
            $response = Http::get($url);
            $data = $response->json();

            $books = [];
            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    $volumeInfo = $item['volumeInfo'];
                    $books[] = [
                        'judul' => $volumeInfo['title'] ?? 'Data Tidak Diketahui',
                        'penerbit' => $volumeInfo['publisher'] ?? 'Data Tidak Diketahui',
                        'tanggalTerbit' => $volumeInfo['publishedDate'] ?? 'Data Tidak Diketahui',
                        'penulis' => isset($volumeInfo['authors']) ? implode(", ", $volumeInfo['authors']) : 'Data Tidak Diketahui',
                        'deskripsi' => $volumeInfo['description'] ?? 'Data Tidak Diketahui',
                        'jumlahHalaman' => $volumeInfo['pageCount'] ?? 'Data Tidak Diketahui',
                        'kategori' => isset($volumeInfo['categories']) ? implode(", ", $volumeInfo['categories']) : 'Data Tidak Diketahui',
                        'cover' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    ];
                }
            }

            $perPage = 5;
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $perPage;

            $paginatedBooks = new LengthAwarePaginator(
                array_slice($books, $offset, $perPage),
                count($books),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        return view('welcome', compact('paginatedBooks', 'book'));
    }

    public function deskripsi(Request $request)
    {
        $deskripsi = $request->query('deskripsi');
        return view('deskripsi', compact('deskripsi'));
    }

    public function jsonFormat(Request $request)
    {
        $book = $request->query('book', 'harry potter');

        if ($book) {
            $apiKey = env('GOOGLE_BOOKS_API_KEY');
            $url = "https://www.googleapis.com/books/v1/volumes?q={$book}&maxResults=1&key={$apiKey}";
            $response = Http::get($url);
            $data = $response->json();
            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    $volumeInfo = $item['volumeInfo'];
                    $books[] = [
                        'judul' => $volumeInfo['title'] ?? 'Data Tidak Diketahui',
                        'penerbit' => $volumeInfo['publisher'] ?? 'Data Tidak Diketahui',
                        'tanggalTerbit' => $volumeInfo['publishedDate'] ?? 'Data Tidak Diketahui',
                        'penulis' => isset($volumeInfo['authors']) ? implode(", ", $volumeInfo['authors']) : 'Data Tidak Diketahui',
                        'deskripsi' => $volumeInfo['description'] ?? 'Data Tidak Diketahui',
                        'jumlahHalaman' => $volumeInfo['pageCount'] ?? 'Data Tidak Diketahui',
                        'kategori' => isset($volumeInfo['categories']) ? implode(", ", $volumeInfo['categories']) : 'Data Tidak Diketahui',
                        'cover' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    ];
                }
            }
        }
        return response()->json($books);
    }
}
