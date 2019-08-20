<?php

namespace BlaudCMS\Http\Requests\Parametrization;

use Illuminate\Foundation\Http\FormRequest;

class ConfigUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('backend_edit_configurations') || 
               $this->user()->can('backend_view_configurations');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_website' => 'nullable',
            'facebook_account' => 'nullable|url',
            'twitter_account' => 'nullable|url',
            'instagram_account' => 'nullable|url',
            'googleplus_account' => 'nullable|url',
            'pinterest_account' => 'nullable|url',
            'linkedin_account' => 'nullable|url',
            'youtube_account' => 'nullable|url',
            'vimeo_account' => 'nullable|url',
            'google_analytics_script' => 'nullable',
            'another_mark_top_script' => 'nullable',
            'another_mark_bottom_script' => 'nullable',
            'advertising_top_script' => 'nullable',
            'advertising_positions' => 'nullable',
            'advertising_bottom_script' => 'nullable',
            'add_this_script' => 'nullable',
            'disqus_script' => 'nullable',
            'contact_map_coordinates' => 'nullable',
            'contact_emails' => 'nullable',
            'sales_emails' => 'nullable',
            'admin_email' => 'nullable|email', 
            'backend_logo' => 'nullable|image', 
            'frontend_logo' => 'nullable|image', 
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
            'facebook_account.url' => 'Por favor ingrese una direccion de Facebook valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'twitter_account.url' => 'Por favor ingrese una direccion de Twitter valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'instagram_account.url' => 'Por favor ingrese una direccion de Instagram valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'googleplus_account.url' => 'Por favor ingrese una direccion de Google+ valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'pinterest_account.url' => 'Por favor ingrese una direccion de Pinterest valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'linkedin_account.url' => 'Por favor ingrese una direccion de Linkedin valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'youtube_account.url' => 'Por favor ingrese una direccion de Youtube valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'vimeo_account.url' => 'Por favor ingrese una direccion de Vimeo valida. Recuerde incluir http:// o https:// al inicio de la URL',
            'admin_email.email' => 'Por favor ingrese una direccion de email valida para el administrador.',
            'backend_logo.image' => 'Por favor ingrese una imagen', 
            'frontend_logo.image' => 'Por favor ingrese una imagen',
        ];
    }
}
