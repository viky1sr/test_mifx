<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BooksController extends Controller
{
    private $bookService;

    public function __construct(
        BookService $bookService
    )
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request){
        if(count($request->all()) != 0){
            Cache::forget('books');
        }
        return $this->bookService->getAll($request->all());
    }

    public function find($id){
        return $this->bookService->getById($id);
    }

    /*
     *  booksValidation is Helper
     */
    public function store(Request $request){
        $validator = booksValidation($request->all());
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validator->errors()->first()
            ],422);
        } else {
            if($book = $this->bookService->create($request->except('_token','submit'))){
                $book->store_book_author($request->author_id);
                return response()->json([
                    'data' => $book
                ],201);
            }
        }
    }
}
