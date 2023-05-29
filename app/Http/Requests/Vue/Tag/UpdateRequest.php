<?php

namespace App\Http\Requests\Vue\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        // dd($this);
        return [
           // 'title' => 'required|unique:tags,title',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'title' => [
                'required', 'string',
                Rule::unique('tags')->ignore($this->tag_id),
            ],
        ];
    }
}
