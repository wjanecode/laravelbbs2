<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SocialAuthorizationRequest extends FormRequest
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
        switch ($this->route('socials_type'))
        {
            case 'weixin':
                return [
                    'code' => 'required',
                ];
            case 'phone':
                return [
                    //
                    'phone' => 'required',
                    'code' => 'required'
                ];
        }
    }




}
