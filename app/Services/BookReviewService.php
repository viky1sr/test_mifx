<?php


namespace App\Services;


use App\Repository\Interfaces\BookReviewRepositoryInterface;

class BookReviewService {
    private $bookReviewRepository;

    public function __construct(
        BookReviewRepositoryInterface $bookReviewRepository
    ) {
        $this->bookReviewRepository = $bookReviewRepository;
    }

    public function create(array $inputs, $book_id){
        return $this->bookReviewRepository->create($inputs,$book_id);
    }

    public function delete($book_id, $reviewId ){
        return $this->bookReviewRepository->delete($book_id,$reviewId);
    }

    public function find($book_id, $reviewId){
        return $this->bookReviewRepository->getById($book_id,$reviewId);
    }
}
