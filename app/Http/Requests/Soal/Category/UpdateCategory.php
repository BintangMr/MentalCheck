<?php

namespace App\Http\Requests\Soal\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            'id' => 'required|numeric',
            'kategori' => 'required|min:2',
            'deskripsi' => 'required|min:2|max:255',
            'background' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'string|required',
        ];
    }
}
