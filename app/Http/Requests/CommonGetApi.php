<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonGetApi extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'perPage'=>'integer|min:1',
            'page'=>'integer|min:1'
        ];
    }
}
