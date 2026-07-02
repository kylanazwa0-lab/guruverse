<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LibraryBook;

class MemberLibraryController extends Controller
{
    public function index()
    {
        $ebooks = LibraryBook::where('type', 'ebook')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($book) {
                $bookArr = $book->toArray();
                $bookArr['price_formatted'] = 'Rp' . number_format($book->price, 0, ',', '.');
                return $bookArr;
            })->toArray();

        return view('member.perpustakaan', compact('ebooks'));
    }
}
