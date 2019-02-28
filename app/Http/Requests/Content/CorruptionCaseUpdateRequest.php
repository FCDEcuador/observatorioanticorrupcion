<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class CorruptionCaseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_corruptioncases');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'case_stage' => 'required',
            'case_stage_detail' => 'nullable',
            'province' => 'required',
            'state_function' => 'required',
            'tags' => 'nullable',
            'involved_number' => 'required|numeric',
            'linked_institutions' => 'required',
            'public_officials_involved' => 'required',
            'main_multimedia' => 'nullable|image',
            'home_image' => 'nullable|image',
            'title' => 'required|unique:corruption_cases,title,'.$this->get('id'),
            'summary' => 'required',
            'history' => 'required',
            'history_image' => 'nullable|image',
            'legal_causes' => 'nullable',
            'political_causes' => 'nullable',
            'consequences_introduction' => 'nullable',
            'consequences_title' => 'nullable',
            //'consequences_description' => 'nullable',
            'economic_consequences' => 'nullable',
            'social_consequences' => 'nullable',
            'sources' => 'nullable',
            'consequences_image' => 'nullable|image',
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
            'case_stage.required' => 'Por favor seleccione la etapa actual del caso',
            'province.required' => 'Por favor seleccione la provincia',
            'state_function.required' => 'Por favor seleccione la Función del Estado',
            'involved_number.required' => 'Por favor ingrese el número de involucrados',
            'involved_number.numeric' => 'Por favor ingrese un número válido de involucrados',
            'linked_institutions.required' => 'Por favor selecciona al menos una institución',
            'public_officials_involved.required' => 'Por favor seleccione al menos un funcionario',
            'main_multimedia.image' => 'Por favor seleccione una imagen principal correcta. Unicamente se aceptan archivos de tipo JPG, PNG y GIF',
            'home_image.image' => 'Por favor seleccione una imagen de home correcta. Unicamente se aceptan archivos de tipo JPG, PNG y GIF',
            'title.required' => 'Por favor ingrese el título del caso',
            'title.unique' => 'Ya existe un caso que lleva ese título',
            'summary.required' => 'Por favor ingrese el resumen del caso',
            'history.required' => 'Por favor ingrese los antecedentes del caso',
            'history_image.image' => 'Por favor seleccione una imagen de antecedentes correcta. Unicamente se aceptan archivos de tipo JPG, PNG y GIF',
            'consequences_image.image' => 'Por favor seleccione una imagen de consecuencias correcta. Unicamente se aceptan archivos de tipo JPG, PNG y GIF',
        ];
    }
}
