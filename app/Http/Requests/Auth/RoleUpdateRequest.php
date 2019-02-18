<?php

namespace BlaudCMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_roles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name,'.$this->get('id'),
            'permissions' => 'required|min:1',
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
            'name.required' => 'El nombre del Rol es obligatorio',
            'name.unique' => 'Ya existe un Rol con ese nombre',
            'permissions.required'  => 'Es obligatorio seleccionar el o los permisos asociados a este Rol',
            'permissions.min'  => 'Debe seleccionar al menos 1 permiso para este Rol',
        ];
    }
}
