<?php


namespace App\Repository;

use App\Repository\Eloquents\BookReviewEloquent;
use App\Repository\Interfaces\BookReviewRepositoryInterface;
use Illuminate\Cache\CacheManager;

class BookReviewCacheRepository implements BookReviewRepositoryInterface {

    protected $repo;
    protected $cache;

    const TTL = 60*60*24; #1day

    public function __construct(
        CacheManager $cache, BookReviewEloquent $repo
    ){
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getAll(array $inputs, $book_id)
    {
        // TODO: Implement getAll() method.
    }

    public function getById($book_id,$reviewId)
    {
        return $this->repo->getById($book_id,$reviewId);
    }

    public function create(array $inputs, $book_id)
    {
        return $this->repo->create($inputs,$book_id);
    }

    public function update(array $inputs, $id, $book_id)
    {
        // TODO: Implement update() method.
    }

    public function delete($book_id,$reviewId)
    {
        return $this->repo->delete($book_id,$reviewId);
    }
}
