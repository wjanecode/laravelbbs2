<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
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
                    'content' => 'required',
                    'post_id' => 'required|exists:posts,id',
                    'user_id' => 'required||exists:users.id'
                ];
            }
            // UPDATE
            case 'PUT':

            case 'PATCH':
            {
                return [
                    // CREATE ROLES
                    'content' => 'required',
                    'post_id' => 'required|exists:posts,id',
                    'user_id' => 'required|exists:users.id'
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
            'comtent.required' => '不能为空'
        ];
    }
}
