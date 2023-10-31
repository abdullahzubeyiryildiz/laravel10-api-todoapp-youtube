<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Support\Facades\Hash;

class TodoRepository
{
    protected $model;

    public function __construct(Todo $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->where('id',$id)->first();
    }


    public function store($data)
    {
        return $this->model->create([
            'name'=>$data['name'],
            'completed'=>$data['completed']
        ]);
    }


    public function update($id, $data)
    {
        return $this->model->where('id',$id)->update([
            'name'=>$data['name'],
            'completed'=>$data['completed']
        ]);
    }

    public function delete($id)
    {
        return $this->model->where('id',$id)->delete();
    }


}
