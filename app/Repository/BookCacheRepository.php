<?php


namespace App\Repository;


use App\Repository\Eloquents\BookEloquent;
use App\Repository\Interfaces\BookRepositoryInterface;
use Illuminate\Cache\CacheManager;

class BookCacheRepository implements BookRepositoryInterface
{
    protected $repo;
    protected $cache;

    const TTL = 60*60*24; #1day

    public function __construct(
        CacheManager $cache, BookEloquent $repo
    ){
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getAll(array $inputs)
    {
        return $this->cache->remember('books', self::TTL, function () use ($inputs) {
            return $this->repo->getAll($inputs);
        });
    }

    public function getById($id)
    {
        return $this->repo->getById($id);
    }

    public function create(array $inputs)
    {
        return $this->repo->create($inputs);
    }

    public function update(array $inputs, $id)
    {
        return $this->repo->update($inputs,$id);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
