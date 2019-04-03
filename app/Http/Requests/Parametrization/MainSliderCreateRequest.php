<?php

namespace BlaudCMS\Http\Requests\Parametrization;

use Illuminate\Foundation\Http\FormRequest;

class MainSliderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_add_mainsliders');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order' => 'required|numeric',
            'image_path' => 'required|image',
            'status' => 'required|in:1,0',
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
            'order.required' => 'Por favor ingrese el orden de aparicion de este slide',
            'order.numeric' => 'Ingrese un número válido',
            'image_path.required' => 'Por favor seleccione una imagen',
            'image_path.image' => 'Unicamente se aceptan imágenes',
            'status.required' => 'Por favor seleccione el estado del slide',
            'status.in' => 'Seleccione unicamente Activo (1) o Inactivo (0)',
        ];
    }
}
