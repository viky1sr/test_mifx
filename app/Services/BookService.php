<?php


namespace App\Services;


use App\Http\Resources\BookResource;
use App\Repository\Interfaces\BookRepositoryInterface;

class BookService {
    private $bookRepository;

    public function __construct(
        BookRepositoryInterface $bookRepository
    ) {
        $this->bookRepository = $bookRepository;
    }

    public function getAll(array $inputs){
        return BookResource::collection($this->bookRepository->getAll($inputs));
    }

    public function getById($id) {
        return $this->bookRepository->getById($id);
    }

    public function create(array $inputs){
        return $this->bookRepository->create($inputs);
    }

    public function update(array $inputs, $id){
        return $this->bookRepository->update($inputs, $id);
    }

    public function delete($id){
        return $this->bookRepository->delete($id);
    }

}
