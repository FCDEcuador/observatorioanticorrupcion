<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class SuccessStoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_successstories');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:success_stories,name,'.$this->get('id'),
            'title' => 'required|min:3',
            'subtitle' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'icon' => 'nullable',
            'url' => 'required|url',
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
            'name.required' => 'Por favor ingrese el nombre de la historia de éxito',
            'name.min' => 'El nombre de la historia de éxito debe tener al menos 3 caracteres',
            'name.unique' => 'Ya existe una historia de éxito con ese nombre',
            'title.required' => 'Por favor ingrese el título de la historia de éxito',
            'title.min' => 'El título de la historia de éxito debe tener al menos 3 caracteres',
            'image.image' => 'Por favor ingrese una imagen válida',
            'url.required' => 'La URL de la historia de éxito es obligatoria',
            'url.url' => 'Por favor ingrese una URL válida.',
        ];
    }
}
