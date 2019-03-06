<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class ContentCategoryCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_add_contentcategories');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:content_categories,name',
            'title' => 'required|unique:content_categories,title',
            'subtitle' => 'nullable',
            'tags' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'extra_headers' => 'nullable',
            'content_category_id' => 'nullable|exists:content_categories,id',
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
            'name.required' => 'Por favor ingrese el nombre de la categoria',
            'name.unique' => 'Ya existe una categoria con ese nombre',
            'title.required' => 'Por favor ingrese el titulo de la categoria',
            'title.unique' => 'Ya existe una categoria con ese titulo',
            'content_category_id.exists' => 'La categoria de nivel superior seleccionada no existe, por favor seleccione otra',
        ];
    }
}
