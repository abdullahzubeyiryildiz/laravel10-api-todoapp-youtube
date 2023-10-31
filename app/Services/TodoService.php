<?php
namespace App\Services;

use App\Repositories\TodoRepository;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAll()
    {
        return $this->todoRepository->getAll();
    }


    public function find($id)
    {
        return $this->todoRepository->find($id);
    }


    public function store($data)
    {
        return $this->todoRepository->store($data);
    }


    public function update($id,$data)
    {
        return $this->todoRepository->update($id,$data);
    } 
    
    public function delete($id)
    {
        return $this->todoRepository->delete($id);
    }


}
