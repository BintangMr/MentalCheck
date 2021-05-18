<?php

namespace App\Http\Requests\Soal;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestion extends FormRequest
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
            'soal' => 'required|min:2',
            'kategori_id' => 'required|numeric',
            'text_jawaban.*' => 'required|string',
            'point_jawaban.*' => 'required|numeric'
        ];
    }
}
