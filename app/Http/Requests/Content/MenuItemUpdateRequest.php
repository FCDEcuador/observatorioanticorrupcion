<?php

namespace BlaudCMS\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_menuitems');
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
            'title' => 'required',
            'link' => 'required',
            'type' => 'required|in:I,E',
            'target' => 'required|in:_self,_blank',
            'order' => 'required|integer',
            'active' => 'required|integer|in:1,0',
            'menu_item_id' => 'nullable|exists:menu_items,id',
            'menu_id' => 'required|exists:menus,id',
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
            'name.required' => 'Por favor ingrese el nombre del item de menú',
            'title.required' => 'Por favor ingrese el título del item de menú',
            'link.required' => 'Por favor ingrese el link o seleccione el link interno del item de menú',
            'type.required' => 'Por favor seleccione el tipo de menú',
            'type.in' => 'El tipo puede se únicamente I (Interno) y E (Externo)',
            'target.required' => 'Por favor seleccione la manera en que se abrirá el link',
            'target.in' => 'Unicamente puede seleccionar que sea en la misma ventana o en una nueva',
            'order.required' => 'Por favor ingrese el órden del menú',
            'order.integer' => 'Para el órden, únicamente se aceptan valores numéricos enteros positivos',
            'active.required' => 'Por favor seleccione el estado del menú',
            'active.integer' => 'El estado puede tomar únicamente los valores de 1 (Activo) y 0 (Inactivo)',
            'active.in' => 'El estado puede tomar únicamente los valores de 1 (Activo) y 0 (Inactivo)',
            'menu_item_id.exists' => 'El item de menú superior seleccionado no existe, por favor seleccione otro.',
            'menu_id.required' => 'Por favor seleccione el menú al que éste item pertenece',
            'menu_id.exists' => 'El menú seleccionado no existe, por favor seleccione otro',
        ];
    }
}
