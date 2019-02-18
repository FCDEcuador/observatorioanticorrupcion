<?php

namespace BlaudCMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_add_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'lastname' => 'nullable|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:6,18|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'avatar' => 'nullable|image',
            'type' => 'required|in:S,A,B,R,U',
            'roles' => 'required|min:1',
            'permissions' => 'nullable',
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
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres.',
            'lastname.min' => 'El apellido del usuario debe tener al menos 3 caracteres.',
            'email.min' => 'El email del usuario es obligatorio.',
            'email.email' => 'El email ingresado no es válido.',
            'email.unique' => 'Ya existe un usuario registrado con ese email.',
            'password.required' => 'El password del usuario es obligatorio.',
            'password.between' => 'El password del usuario debe tener entre 6 y 18 caracteres.',
            'password.confirmed' => 'El password y la confirmación no coinciden.',
            'password.regex' => 'El password debe tener al menos 1 mayúscula, 1 minúscula, 1 dígito y un caracter especial ().,:;#$%&/[]{}.',
            'avatar.image' => 'El Avatar del usuario debe ser una imagen con formato JPG, JPEG, PNG o GIF.',
            'type.required' => 'Por favor seleccione el tipo de usuario',
            'type.in' => 'Por favor seleccione un tipo válido de usuario',
            'roles.required' => 'Es obligatorio seleccionar el o los roles del usuario.',
            'roles.min' => 'Debe seleccionar al menos 1 rol para el usuario.',
        ];
    }
}
