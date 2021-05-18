<?php

namespace App\Http\Requests\Soal\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
            'kategori' => 'required|min:2',
            'deskripsi' => 'required|min:2',
            'background' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'string|required',
        ];
    }
}
