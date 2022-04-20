<?php


namespace App\Repository\Interfaces;


interface BookReviewRepositoryInterface
{
    public function getAll(array $inputs, $book_id);
    public function getById($book_id,$reviewId);
    public function create(array $inputs,$book_id);
    public function update(array $inputs, $id, $book_id);
    public function delete($book_id,$reviewId);
}
