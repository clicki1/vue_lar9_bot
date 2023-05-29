<?php

namespace App\Http\Requests\Vue\Graphic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
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
           // 'coast' => 'integer|nullable',
            'message_id' => 'integer|nullable',
            'year_res' => 'integer|nullable',
            'month_res' => 'integer|nullable',
            'category_id' => 'integer|nullable',
            'err_cat' => 'integer|nullable',
        ];
    }
}
