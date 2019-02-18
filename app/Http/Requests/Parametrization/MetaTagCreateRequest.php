<?php

namespace BlaudCMS\Http\Requests\Parametrization;

use Illuminate\Foundation\Http\FormRequest;

class MetaTagCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_add_metatags');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type' => 'required',
            'value' => 'nullable',
            'extra_attributes' => 'nullable',
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
            'name.required' => 'Por favor ingrese el parametro name del meta tag',
            'type.required' => 'Por favor seleccione el tipo de meta tag',
        ];
    }
}
