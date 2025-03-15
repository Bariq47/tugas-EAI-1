<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $book = $request->query('book', 'laravel');
        $bookData = null;
        $error = null;

        if ($book) {
            $apiKey = env('GOOGLE_BOOKS_API_KEY');
            $url = "https://www.googleapis.com/books/v1/volumes?q={$book}&maxResults=40&key={$apiKey}";
            $response = Http::get($url);
            $data = $response->json();

            if (isset($data['error'])) {
                $error = $data['error']['info'];
            } elseif (!empty($data['items'])) {
                $volumeInfo = $data['items'][0]['volumeInfo'];
                $bookData = [
                    'judul' => $volumeInfo['title'] ,
                    'penerbit' => $volumeInfo['publisher'],
                    'tanggalTerbit' => $volumeInfo['publishedDate'] ,
                    'penulis' => implode(", ", $volumeInfo['authors']),
                    'deskripsi' => $volumeInfo['description'],
                    'jumlahHalaman' => $volumeInfo['pageCount'],
                    'kategori' => implode(", ", $volumeInfo['categories']),
                    'cover' => $volumeInfo['imageLinks']['thumbnail'],
                ];
            }
  
        }

        return view('welcome', compact('bookData', 'error', 'book'));
    }

    public function deskripsi(Request $request)
    {
        $deskripsi = $request->query('deskripsi');
        // $judul = $request->query('judul');
        return view('deskripsi', compact('deskripsi'));
    }
}
