@extends('backend.layouts.backend-layout')

@section('custom-css')
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
@endsection

@section('title')
	Elementos de Home
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
                    <li class="breadcrumb-item active">Elementos de Home</li>
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
                                  Elementos de Home
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
                        {!! Form::model($oHomeField, ['route' => ['backend.parametrization.home-fields.save'], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'homeFieldsForm', 'id' => 'homeFieldsForm', 'files' => true]) !!}

                            <div class="form-group">
                                <label for="legal_library_text"><strong>Texto para Biblioteca Legal</strong></label>
                                {!! Form::textarea('legal_library_text', null, ['id' => 'legal_library_text', 'placeholder' => 'Ingrese el texto para el elemento de home Biblioteca Legal', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="legal_library_image">
                                    <strong>Imagen de Biblioteca Legal : </strong><br />
                                    <small>Por favor seleccione la imagen que acompaña al texto de Biblioteca Legal. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                </label>
                                @php
                                    $dataDefaultFile = '';
                                    if($oHomeField->legal_library_image){
                                        $dataDefaultFile = asset($oStorage->url($oHomeField->legal_library_image));
                                    }
                                @endphp
                                {!! Form::file('legal_library_image', ['id' => 'legal_library_image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                            </div>


                            <div class="form-group">
                                <label for="success_stories_title"><strong>Titulo para Historias de Exito</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="home-field-success-stories-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('success_stories_title', null, ['id' => 'success_stories_title', 'placeholder' => 'Ingrese el titulo para el elemento de home Historias de Exito', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="success_stories_text"><strong>Texto para Historias de Exito</strong></label>
                                {!! Form::textarea('success_stories_text', null, ['id' => 'success_stories_text', 'placeholder' => 'Ingrese el texto para el elemento de home Historias de Exito', 'class' => 'form-control']) !!}
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="homeFieldsBtn" id="homeFieldsBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar</span>
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
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-home-field.min.js', ['type' => 'text/javascript']) !!}
@endsection