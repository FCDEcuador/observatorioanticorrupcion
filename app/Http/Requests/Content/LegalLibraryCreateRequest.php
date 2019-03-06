<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class LegalLibraryCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_add_legallibraries');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|unique:legal_libraries,title',
            'description' => 'nullable',
            'issue_year' => 'required|numeric',
            'pdf_document' => 'nullable|file',
            'tags' => 'nullable',
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
            'title.required' => 'Por favor ingrese el título.',
            'title.min' => 'EL título debe tener al menos 3 caracteres.',
            'title.unique' => 'Ya existe un artículo con este título.',
            'issue_year.required' => 'Por favor ingrese el año de emisión.',
            'issue_year.numeric' => 'Por favor ingrese un año válido.',
            'pdf_document.file' => 'Por favor seleccione un archivo.',
        ];
    }
}
