<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Requests\ToDoRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\ToDoCollection;
use App\Http\Resources\ToDoResource;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function fetchtag()
    {
        return response()->json([
            'status' => 200,
            'tags' => new TagCollection(Tag::all()),
        ]);
    }

    public function store(TagRequest $request)
    {
        $tag = $request->all();
        Tag::create($tag);

        return response()->json([
            'status' => 200,
            'message' => 'Тэг добавлен.',
        ]);
    }
}
