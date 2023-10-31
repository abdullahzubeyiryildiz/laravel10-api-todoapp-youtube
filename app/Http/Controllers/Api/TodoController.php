<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\TodoService;
use App\Http\Requests\TodoRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

   public function index(Request $request){

           $todos = TodoResource::collection($this->todoService->getAll());
           return apiResponse(__('Todo'),200,  $todos);
   }


   public function store(TodoRequest $request){
        $data = $request->all();

        $todo = $this->todoService->store($data);

        return apiResponse(__('Todo'),200, $todo);
    }


   public function edit($id, Request $request){

        return   $this->todoService->find($id);
    }



   public function update($id, TodoRequest $request){
    $data = $request->all();

     $this->todoService->update($id,$data);

    $todo = $this->todoService->find($id);

    return apiResponse(__('Todo'),200, $todo);
}


public function destroy($id, Request $request){

     $this->todoService->delete($id);
    return apiResponse(__('Todo'),200);
}


}
