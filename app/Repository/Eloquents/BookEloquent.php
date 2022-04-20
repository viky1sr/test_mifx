<?php


namespace App\Repository\Eloquents;


use App\Book;
use App\Repository\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class BookEloquent implements BookRepositoryInterface
{
    private $model;

    public function __construct(Book $model) {
        $this->model = $model;
    }

    public function getAll(array $inputs)
    {
        $query = $this->model;

        $s = (!empty($inputs["search"])) ? ($inputs["search"]) : ("");
        $sort = (!empty($inputs["sort"])) ? ($inputs["sort"]) : ("");
        $sort_by = (!empty($inputs["sort_by"])) ? ($inputs["sort_by"]) : ("");

        if($s){
            $query = $query->where('isbn','LIKE',($s ? '%'.$s.'%' : '%%'))
                ->orWhere('title','LIKE',($s ? '%'.$s.'%' : '%%'))
                ->orWhereHas('authors', function ($q) use ($s){
                    $q->where('name','LIKE',($s ? '%'.$s.'%' : '%%'))
                        ->orWhere('surname','LIKE',($s ? '%'.$s.'%' : '%%'));
                });
        }

        if($sort && $sort_by){
            $query = $query->orderBy($sort_by, $sort);
        }

        return $query->paginate(10);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $inputs)
    {
        return $this->model->create($inputs);
    }

    public function update(array $inputs, $id)
    {
        $book = $this->model->find($id);
        $book->update($inputs);

        return $book;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
