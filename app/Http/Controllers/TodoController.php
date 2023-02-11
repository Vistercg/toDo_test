<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoRequest;
use App\Http\Resources\ToDoCollection;
use App\Http\Resources\ToDoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        return view('toDo');
    }

    public function fetchtodo()
    {
        $todos = ToDo::where('user_id', Auth::user()->id)->get();
        $todos_json = new ToDoCollection($todos->loadMissing('tags'));
        return response()->json([
            'todos' => $todos_json,
        ]);
    }

    public function store(ToDoRequest $request)
    {
        new ToDoResource(Todo::create($request->all()));
        return response()->json([
            'status' => 200,
            'message' => 'Задача добавлена.'
        ]);
    }

    public function edit($id)
    {
        $todo = new ToDoResource(Todo::find($id)->loadMissing('tags'));
        if ($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Задача не найдена.'
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'description' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $todo = Todo::find($id);
            if ($todo) {
                $todo->name = $request->input('name');
                $todo->description = $request->input('description');
                $todo->status = $request->input('status');
                $todo->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Задача обновлена.'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Такой задачи не найдено.'
                ]);
            }

        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Задача успешно удалена.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Такой задачи не найдено.'
            ]);
        }
    }
}
