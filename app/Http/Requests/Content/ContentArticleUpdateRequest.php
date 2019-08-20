<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class ContentArticleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_contentarticles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:content_articles,title,'.$this->get('id'),
            'summary' => 'required',
            'content' => 'nullable',
            'main_multimedia' => 'nullable|image',
            'author' => 'nullable',
            'author_email' => 'nullable',
            'source' => 'nullable',
            'tags' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'extra_headers' => 'nullable',
            'content_category_id' => 'required|exists:content_categories,id',
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
            'title.required' => 'Por favor ingrese el título del artículo',
            'title.unique' => 'Ya existe un artículo con ese título',
            'summary.required' => 'Por favor ingrese el resumen del artículo',
            'main_multimedia.image' => 'Unicamente se aceptan archivos de imagen (JPG, PNG, GIF)',
            'content_category_id.required' => 'Por favor seleccione la categoría a la que pertenece el artículo',
            'content_category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
