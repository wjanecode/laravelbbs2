<?php

namespace App\Http\Requests;

class PostRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'title' => 'required',
                    'body'  => 'required|min:10'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // CREATE ROLES
                    'title' => 'required',
                    'body'  => 'required|min:10'
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            // Validation messages
            'title.required' => '标题不能为空',
            'body.required'  => '内容不能为空,不能少于10字符',
            'body.min'       => '内容不能少于10字符'
        ];
    }
}
