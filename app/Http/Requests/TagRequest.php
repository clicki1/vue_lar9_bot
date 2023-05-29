<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
       // dd($this->tags);
        return [
            'title' => 'required|unique:tags,title',
           // 'title' => ['required', Rule::unique('tags')->where('id', $this->tags)],
            //'category_id' => ['required','integer', Rule::exists('catagories')->where('id', $this->category_id)],
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
