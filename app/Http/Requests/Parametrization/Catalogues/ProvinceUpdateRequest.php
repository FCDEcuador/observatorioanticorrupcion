<?php

namespace BlaudCMS\Http\Requests\Parametrization\Catalogues;

use Illuminate\Foundation\Http\FormRequest;

class ProvinceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_provinces');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'code' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'Por favor ingrese el nombre de la provincia',
            'code.required' => 'Por favor ingrese el código de la provincia',
            'code.integer' => 'Por favor ingrese un código de provincia válido',
        ];
    }
}
