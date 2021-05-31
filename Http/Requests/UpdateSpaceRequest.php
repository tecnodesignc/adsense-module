<?php

namespace Modules\Adsense\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpaceRequest extends FormRequest
{
    public function rules()
    {
        $space = $this->route()->parameter('space');

        return [
            'name' => 'required',
            'primary' => "unique:adsense__spaces,primary,{$space->id}",
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('adsense::validation.name is required'),
            'system_name.required' => trans('adsense::validation.system name is required')
        ];
    }
}
