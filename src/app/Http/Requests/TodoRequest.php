<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            // required: 入力必須
            // string: 文字型
            // max:20: 20文字以内
            'content' => ['required', 'string', 'max:20'],
            // IDがリクエストに含まれている（＝更新処理である）場合は nullable、それ以外（＝作成）は required
            'category_id' => $this->has('id') ? ['nullable'] : ['required'],
            'deadline' => 'nullable|date|after:now',
        ];        
    }

    public function messages()
    {
        return [
            'content.required' => 'Todoを入力してください',
            'content.string'   => 'Todoを文字列で入力してください',
            'content.max'      => 'Todoを20文字以内で入力してください',
            'category_id.required' => 'カテゴリを選んでください',
        ];
    }
}
