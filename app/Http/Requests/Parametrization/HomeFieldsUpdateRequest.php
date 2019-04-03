<?php

namespace BlaudCMS\Http\Requests\Parametrization;

use Illuminate\Foundation\Http\FormRequest;

class HomeFieldsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_homefields') || 
               $this->user()->can('backend_view_homefields');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'legal_library_text' => 'nullable',
            'legal_library_image' => 'nullable|image',
            'success_stories_title' => 'nullable',
            'success_stories_text' => 'nullable',
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
            'legal_library_image.image' => 'Por favor seleccione una imagen',
        ];
    }
}
