<?php

namespace App\Http\Requests\Soal\Answer;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswer extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'soal_id' => 'required|numeric',
            'jawaban' => 'required|min:2|max:255',
            'poin' => 'required|min:0|numeric'
        ];
    }
}
