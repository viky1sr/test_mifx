<?php


namespace App\Repository\Interfaces;

interface BookRepositoryInterface {
    public function getAll(array $inputs);
    public function getById($id);
    public function create(array $inputs);
    public function update(array $inputs, $id);
    public function delete($id);
}
