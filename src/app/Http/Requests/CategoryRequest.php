<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            // categoriesテーブルのnameカラムで重複がないかチェック
            'name' => 'required|string|max:10|unique:categories,name',
        ];
    }

    public function messages()
    {
        return [
                'name.required' => 'カテゴリを入力してください',
                'name.string'   => 'カテゴリを文字列で入力してください',
                'name.max'      => 'カテゴリを10文字以内で入力してください',
                'name.unique'   => 'カテゴリが既に存在しています',
        ];
    }
}

