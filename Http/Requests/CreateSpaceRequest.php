<?php namespace Modules\Adsense\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpaceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'system_name' => 'required'
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
