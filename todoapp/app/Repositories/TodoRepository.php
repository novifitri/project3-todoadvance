<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository 
{
    protected $todo;
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    //untuk mengambil semua data di collection
    public function getAll() : Object
    {
        $todos = $this->todo->get();
        return $todos;
    }

    //untuk mencari data todo
    public function getById(string $id)
    {
	    $todo = $this->todo->find(['_id'=>$id])->first();
		return $todo;
    }

    //untuk menyimpan data todo
    public function store($data)
    {
        $newTodo = new $this->todo;
        $newTodo->title = $data["title"];
        $newTodo->description = $data["description"];
        $newTodo->save();
        return $newTodo->fresh();
    }

    //untuk memperbarui data todo
    public function update($id, array $data)
    {
        $todo = $this->getById($id);
        $todo->title = $data["title"];
        $todo->description = $data["description"];
        $todo->save();
        return $todo->fresh();
    }
     //untuk menghapus data todo
     public function delete(string $id)
     {
        $todo = $this->getById($id);
        $todo->delete();
     }
}
