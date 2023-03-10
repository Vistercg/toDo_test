<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ToDoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=> 'required|max:191',
            'description'=>'required|max:191',
            'user_id' => 'required',
            'tags' => '',
            'tag' => '',
            'todo_id' =>'',
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,bmp', 'max:5120'],
            'imagetodo_path' => '',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' =>  Auth::user()->id,
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validate errors',
            'data' => $validator->errors()
        ], 400));
    }
}
