<?php


namespace App\Repository\Eloquents;

use App\BookReview;
use App\Repository\Interfaces\BookReviewRepositoryInterface;

class BookReviewEloquent implements BookReviewRepositoryInterface {
    private $model;

    public function __construct(BookReview $model) {
        $this->model = $model;
    }
    public function getAll(array $inputs, $book_id)
    {
        // TODO: Implement getAll() method.
    }

    public function getById($book_id,$reviewId)
    {
        $res = $this->model->with('user')->where('book_id', $book_id)->where('id',$reviewId)->first();
        $data = [
            'id' => $res->id,
            'review' => $res->review,
            'comment' => $res->comment,
            'user' => [
                'id' => $res->user->id,
                'name' => $res->user->name,
            ]
        ];
        return $data;
    }

    public function create(array $inputs, $book_id)
    {
        $req = array_merge($inputs,['book_id' => $book_id]);
        return $this->model->create($req);
    }

    public function update(array $inputs, $id, $book_id)
    {
        // TODO: Implement update() method.
    }

    public function delete($book_id,$reviewId)
    {
        $data = $this->model->where('id',$reviewId)->where('book_id',$book_id);
        return $data->delete();
    }
}
