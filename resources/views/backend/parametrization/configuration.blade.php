@extends('backend.layouts.backend-layout')

@section('custom-css')
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
@endsection

@section('title')
	Configuracion
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">BlaudCMS</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item active">Configuracion</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">
                                  Configuracion
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                        </div>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulario de usuarios -->
                        {!! Form::model($oConfiguration, ['route' => ['backend.parametrization.configuration.save'], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'configForm', 'id' => 'configForm', 'files' => true]) !!}

                            <div class="form-group">
                                <label for="title_website"><strong>Titulo del Web Site</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-title-website">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('title_website', null, ['id' => 'title_website', 'placeholder' => 'Ingrese el titulo del sitio web', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="facebook_account"><strong>Cuenta de Facebook</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-facebook-account">
                                            <i class="ti-facebook"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('facebook_account', null, ['id' => 'facebook_account', 'placeholder' => 'https://facebook.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="twitter_account"><strong>Cuenta de Twitter</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-twitter-account">
                                            <i class="ti-twitter"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('twitter_account', null, ['id' => 'twitter_account', 'placeholder' => 'https://twitter.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="instagram_account"><strong>Cuenta de Instagram</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-instagram-account">
                                            <i class="ti-instagram"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('instagram_account', null, ['id' => 'instagram_account', 'placeholder' => 'https://instagram.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="googleplus_account"><strong>Cuenta de Google+</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-google-plus-account">
                                            <i class="ti-google"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('googleplus_account', null, ['id' => 'googleplus_account', 'placeholder' => 'https://plus.google.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pinterest_account"><strong>Cuenta de Pinterest</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-pinterest-account">
                                            <i class="ti-pinterest"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('pinterest_account', null, ['id' => 'pinterest_account', 'placeholder' => 'https://pinterest.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="linkedin_account"><strong>Cuenta de Linkedin</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-linkedin-account">
                                            <i class="ti-linkedin"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('linkedin_account', null, ['id' => 'linkedin_account', 'placeholder' => 'https://linkedin.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="youtube_account"><strong>Cuenta de Youtube</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-youtube-account">
                                            <i class="ti-youtube"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('youtube_account', null, ['id' => 'youtube_account', 'placeholder' => 'https://youtube.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="vimeo_account"><strong>Cuenta de Vimeo</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-vimeo-account">
                                            <i class="ti-vimeo"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('vimeo_account', null, ['id' => 'vimeo_account', 'placeholder' => 'https://vimeo.com/cuenta', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="admin_email"><strong>Email del Administrador</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="config-admin-mail">
                                            <i class="ti-email"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('admin_email', null, ['id' => 'admin_email', 'placeholder' => 'admin@dominio.com', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="backend_logo">
                                            <strong>Logo para Backend : </strong><br />
                                            <small>Por favor seleccione el logo que se colocará en el backend de este sitio. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                        </label>
                                        @php
                                            $dataDefaultFile = '';
                                            if($oConfiguration->backend_logo){
                                                $dataDefaultFile = asset($oStorage->url($oConfiguration->backend_logo));
                                            }
                                        @endphp
                                        {!! Form::file('backend_logo', ['id' => 'backend_logo', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="frontend_logo">
                                            <strong>Logo para Frontend : </strong><br />
                                            <small>Por favor seleccione el logo que se colocará en el frontend de este sitio. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                        </label>
                                        @php
                                            $dataDefaultFile = '';
                                            if($oConfiguration->frontend_logo){
                                                $dataDefaultFile = asset($oStorage->url($oConfiguration->frontend_logo));
                                            }
                                        @endphp
                                        {!! Form::file('frontend_logo', ['id' => 'frontend_logo', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="google_analytics_script">
                                    <strong>
                                        Script de Google Analytics
                                    </strong>
                                </label>
                                {!! Form::textarea('google_analytics_script', null, ['id' => 'google_analytics_script', 'placeholder' => 'Pegue aqui el script proporcionado por Google Analytics', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="another_mark_top_script">
                                    <strong>
                                        Script de Otra Marcacion (cabecera)
                                    </strong>
                                </label>
                                {!! Form::textarea('another_mark_top_script', null, ['id' => 'another_mark_top_script', 'placeholder' => 'Pegue aqui el script que se deba colocar en la cabecera del sitio proporcionado por su proveedor', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="another_mark_bottom_script">
                                    <strong>
                                        Script de Otra Marcacion (pie)
                                    </strong>
                                </label>
                                {!! Form::textarea('another_mark_bottom_script', null, ['id' => 'another_mark_bottom_script', 'placeholder' => 'Pegue aqui el script que se deba colocar en el pie del sitio proporcionado por su proveedor', 'class' => 'form-control']) !!}
                            </div>

                            <!--
                            <div class="form-group">
                                <label for="advertising_top_script">
                                    <strong>
                                        Script de Publicidad (cabecera)
                                    </strong>
                                </label>
                                {!! Form::textarea('advertising_top_script', null, ['id' => 'advertising_top_script', 'placeholder' => 'Pegue aqui el script que se deba colocar en la cabecera del sitio proporcionado por su proveedor de publicidad', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="advertising_bottom_script">
                                    <strong>
                                        Script de Publicidad (pie)
                                    </strong>
                                </label>
                                {!! Form::textarea('advertising_bottom_script', null, ['id' => 'advertising_bottom_script', 'placeholder' => 'Pegue aqui el script que se deba colocar en el pie del sitio proporcionado por su proveedor de publicidad', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="advertising_bottom_script">
                                    <strong>
                                        Posiciones de Publicidad
                                    </strong>
                                </label>
                                {!! Form::textarea('advertising_bottom_script', null, ['id' => 'advertising_bottom_script', 'placeholder' => 'Coloque aqui las posiciones de publicidad que se van a configurar en el sitio.', 'class' => 'form-control']) !!}
                            </div>

                            -->

                            <div class="form-group">
                                <label for="add_this_script">
                                    <strong>
                                        Script AddThis
                                    </strong>
                                </label>
                                {!! Form::textarea('add_this_script', null, ['id' => 'add_this_script', 'placeholder' => 'Pegue aqui el script proporcionado por AddThis.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="disqus_script">
                                    <strong>
                                        Script Disqus
                                    </strong>
                                </label>
                                {!! Form::textarea('disqus_script', null, ['id' => 'disqus_script', 'placeholder' => 'Pegue aqui el script proporcionado por Disqus.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="contact_emails">
                                    <strong>
                                        Correo(s) de Contacto
                                    </strong>
                                </label>
                                {!! Form::textarea('contact_emails', null, ['id' => 'contact_emails', 'placeholder' => 'Coloque aqui la o las direcciones de email para el envio de los datos del formulario de contacto. Si es mas de una por favor ingreselas separadas por una coma (,): Ej: contacto_1@dominio.com, contacto_2@dominio.com', 'class' => 'form-control']) !!}
                            </div>

                            <!--
                            <div class="form-group">
                                <label for="sales_emails">
                                    <strong>
                                        Correo(s) de Ventas
                                    </strong>
                                </label>
                                {!! Form::textarea('sales_emails', null, ['id' => 'sales_emails', 'placeholder' => 'Coloque aqui la o las direcciones de email para el envio de los datos de formularios de consulta de usuarios acerca de productos del e-commerce. Si es mas de una por favor ingreselas separadas por una coma (,): Ej: ventas_1@dominio.com, ventas_2@dominio.com', 'class' => 'form-control']) !!}
                            </div>
                            -->

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="configBtn" id="configBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Configuracion</span>
                                </button>
                            </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('custom-js')
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/jquery.validate.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/additional-methods.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/dropify/dist/js/dropify.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-config.min.js', ['type' => 'text/javascript']) !!}
@endsection