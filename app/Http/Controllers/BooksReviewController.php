<?php

namespace App\Http\Controllers;

use App\Services\BookReviewService;
use Illuminate\Http\Request;

class BooksReviewController extends Controller
{
    private $bookReviewService;

    public function __construct(
        BookReviewService $bookReviewService
    )
    {
        $this->bookReviewService = $bookReviewService;
    }

    public function store(int $bookId, Request $request)
    {
        $validator = bookReviewValidation($request->all());

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validator->errors()->first()
            ],422);
        } else {
            $id_user = isset(\Auth::user()->id ) ? \Auth::user()->id  : 1;
            $input = array_merge($request->all(),['user_id' => $id_user ]);
            if($res = $this->bookReviewService->create($input,$bookId)){
                $data = $this->bookReviewService->find($bookId,$res->id);
                return response()->json([
                    'data' => $data
                ],201);
            }
        }
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        if(\Auth::user()->is_admin){
            $delete = $this->bookReviewService->delete($bookId,$reviewId);
            if($delete){
                return response()->json([
                    'status' => true,
                    'message' => 'Success delete data.'
                ],200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
                ],422);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Your not admin, u cant delete data.'
            ],422);
        }
    }
}
