<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method())
        {
            case 'POST':
                return [
                    //
                    // CREATE ROLES
                    'title' => 'required|string',
                    'body'  => 'required|min:10|string',
                    'category_id' => 'required|exists:categories,id',//在categories表id字段中存在
                ];
                break;
            case 'PATCH':
                return [
                    'title' => 'string',
                    'body'  => 'min:10',
                    'category_id' => 'exists:categories,id',//在categories表id字段中存在
                ];
                break;
        }

    }
    public function messages()
    {
        return [
            // Validation messages
            'title.required' => '标题不能为空',
            'body.required'  => '内容不能为空,不能少于10字符',
            'body.min'       => '内容不能少于10字符',
            'category_id'    => '分类不能为空'
        ];
    }
}
