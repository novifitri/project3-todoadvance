<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }
    //untuk ambil semua data
    public function getAll()
    {
        $todos = $this->todoRepository->getAll();
        return $todos;
    }
    //untuk ambil satu data berdasarkan id
    public function getById(string $id)
    {
        $todo = $this->todoRepository->getById($id);
        return $todo;
    }
    //untuk menambah todo
    public function addTodo($data)
    {
        $validator = Validator::make($data, [
            "title" => "required",
            "description" => "required"
        ]);
        //jika validasi gagal
        if($validator->fails())
        {
            throw new InvalidArgumentException(json_encode($validator->errors()));
        }
        $todo= $this->todoRepository->store($data);
		return $todo;
    }
    //untuk mengedit todo
    public function editTodo($id, array $todo)
    {
       
        $validator = Validator::make($todo, [
            "title" => "required",
            "description" => "required"
        ]);
        //jika validasi gagal
        if($validator->fails())
        {
            throw new InvalidArgumentException(json_encode($validator->errors()));
        }
        $updatedTodo = $this->todoRepository->update($id, $todo);
		return $updatedTodo;
    }
     //untuk menghapus todo
    public function deleteTodo(string $id)
    {
        $this->todoRepository->delete($id);
    }
}