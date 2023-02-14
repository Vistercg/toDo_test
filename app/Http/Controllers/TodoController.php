<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\ToDoCollection;
use App\Http\Resources\ToDoResource;
use App\Models\Tag;
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

    public function fetchtodo(Request $request)
    {
        $query = $request->get('query');
        if ($query != '') {
            $user_id = Auth::user()->id;
            $todos = ToDo::where(function ($id) use ($user_id) {
                $id->where('user_id', '=', $user_id);
            })->where(function ($data) use ($query) {
                $data->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('status', 'like', '%' . $query . '%');
                })
                ->get();

            /*$todos = ToDo::where('user_id', Auth::user()->id)
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('description', 'like', '%'.$query.'%')
                ->orWhere('status', 'like', '%'.$query.'%')
                ->get();*/
        } else {
            $todos = ToDo::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->get();
        }
        $todos_json = new ToDoCollection($todos->loadMissing('tags'));

        return response()->json([
            'todos' => $todos_json,
        ]);
    }

    public function store(ToDoRequest $request)
    {
        $this->_fillTodoByRequest(new Todo(), $request);

        return response()->json([
            'status' => 200,
            'message' => 'Задача добавлена.',
        ]);
    }

    public function edit($id)
    {
        $todo = new ToDoResource(Todo::find($id)->loadMissing('tags'));
        if ($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo,
                'todoIds' => $todo->tags()->pluck('tag_id'),
                'tags' => new TagCollection(Tag::all())
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Задача не найдена.'
            ]);
        }

    }

    public function update(ToDoRequest $request)
    {
        $todo = Todo::find($request->todo_id);

        if (!$todo) {
            return response()->json([
                'status' => 404,
                'message' => 'Такой задачи не найдено.',
            ]);
        }

        $this->_fillTodoByRequest($todo, $request);

        return response()->json([
            'status' => 200,
            'message' => 'Задача обновлена.'
        ]);
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

    private function _fillTodoByRequest(Todo $todo, ToDoRequest $request)
    {

        $image = $todo->image;
        $todo->fill($request->all());
        $todo->tags()->detach();
        if (!empty($request->tags)) {
            $todo->tags()->attach(Tag::whereIn('id', $request->tags)->get());
        }

        if (!empty($request->file('image'))) {
            $todo->image = $request->file('image')->store('image', 'public');
        } else {
            $todo->image = $image;
        }

        $todo->save();

        if (!empty($request->tag)) {
            $todo->tags()->attach($request->tag);
        }

        return $todo;
    }
}
