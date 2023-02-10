<?php

namespace App\Http\Controllers;

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
        $todos = Todo::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'todos'=>$todos,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'description'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $todo = new Todo();
            $todo->name = $request->input('name');
            $todo->description = $request->input('description');
            $todo->user_id = Auth::user()->id;
            $todo->save();
            return response()->json([
                'status'=>200,
                'message'=>'Задача добавлена.'
            ]);
        }

    }

    public function edit($id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            return response()->json([
                'status'=>200,
                'todo'=> $todo,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Задача не найдена.'
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'description'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $todo = Todo::find($id);
            if($todo)
            {
                $todo->name = $request->input('name');
                $todo->description = $request->input('description');
                $todo->status = $request->input('status');
                $todo->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Задача обновлена.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Такой задачи не найдено.'
                ]);
            }

        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            $todo->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Задача успешно удалена.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Такой задачи не найдено.'
            ]);
        }
    }
}
