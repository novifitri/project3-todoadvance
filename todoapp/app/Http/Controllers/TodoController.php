<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Exception;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function getTodoList()
    {
        $todos = $this->todoService->getAll();
        return response()->json([
            "statusCode" => 200,
            "message" => "list semua todo",
            "data" =>$todos
        ],200);
    }

    //untuk menambah todo baru
    public function createTodo(Request $request)
    {
        $data = $request->only(["title", "description"]);
        $result = ["statusCode" => 200];
        try {
            $result["message"] = "Berhasil menambah todo";
            $result["data"] = $this->todoService->addTodo($data);
        } catch (Exception $e) {
            $result = [
                "statusCode" => 400,
                "error" => json_decode($e->getMessage()),
            ];
        }

        return response()->json($result, $result["statusCode"]);
    }

     //untuk memperbarui todo 
    public function updateTodo($id, Request $request)
    {
         //cari todo
        $isExist = $this->todoService->getById($id);
        if(!$isExist)
        {
            $result = [
                "statusCode" => 404,
                "message" => "Data todo tidak ditemukan"
            ];
            return response()->json($result, $result["statusCode"]);
        }
        $data = $request->only(["title", "description"]);
        $result = ["statusCode" => 200];
        try {
            $result["message"] = "Berhasil mengupdate todo";
            $result["data"] = $this->todoService->editTodo($id, $data);
        } catch (Exception $e) {
            $result = [
                "statusCode" => 400,
                "error" => $e->getMessage(),
            ];
        }

        return response()->json($result, $result["statusCode"]);
    }

    //untuk hapus todo
    public function deleteTodo(string $id)
    {
        $isExist = $this->todoService->getById($id);
        if(!$isExist)
        {
            $result = [
                "statusCode" => 404,
                "message" => "Data todo tidak ditemukan"
            ];
            return response()->json($result, $result["statusCode"]);
        }
        $this->todoService->deleteTodo($id);
        return response()->json([
            "statusCode" => 200,
            "message" => "todo id ".$id ." berhasil dihapus"
        ]);
    }
}
