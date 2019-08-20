<?php

namespace BlaudCMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'name' => 'required',
            'lastname' => 'nullable',
            'email' => 'required|email|unique:users,email,'.$this->user()->id,
            'password' => 'nullable|between:4,12|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'avatar' => 'nullable|image',
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
            'name.required' => 'Por favor ingrese su nombre',
            'lastname.required' => 'Por favor ingrese su apellido',
            'email.required' => 'Por favor ingrese su direccion de email',
            'email.email' => 'Por favor ingrese una direccion de email valida',
            'email.unique' => 'Ya existe un usuario con la direccion de email ingresada',
            'password.between' => 'La clave debe tener entre 4 y 12 caracteres',
            'password.confirmed' => 'La clave y la confirmacion no coinciden',
            'password.regex' => 'La clave debe tener al menos una minuscula, una mayuscula y un numero',
            'avatar.image' => 'Por favor seleccione un archivo de imagen para su avatar (JPG, JPEG, PNG o GIF)',
        ];
    }
}
