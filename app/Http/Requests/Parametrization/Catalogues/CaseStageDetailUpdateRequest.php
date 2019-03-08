<?php

namespace BlaudCMS\Http\Requests\Parametrization\Catalogues;

use Illuminate\Foundation\Http\FormRequest;

class CaseStageDetailUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_casestagedetails');
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
            'catalogue_id' => 'required|exists:catalogs,id',
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
            'description.required' => 'Por favor ingrese el nombre del detalle de etapa actual del caso',
            'catalogue_id.required' => 'Por favor seleccione la etapa del caso',
            'catalogue_id.exists' => 'La etapa del caso seleccionada no existe, por favor seleccione otra',
        ];
    }
}
