@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('backend/assets/css/pages/ui-bootstrap-page.css') !!}
    {!! Html::style('backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Historias de Éxito
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Historias de Éxito</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.success-stories.list') !!}">Historias de Éxito</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oSuccessStory))
                            Editar Historia de Éxito
                        @else
                            Agregar Historia de Éxito
                        @endif
                    </li>
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
                                  @if(is_object($oSuccessStory))
                                    Editar Historia de Éxito
                                  @else
                                    Agregar Historia de Éxito 
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_successstories')
                                    <a href="{!! route('backend.content.success-stories.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Historias de Éxito
                                    </a>
                                @endcan
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

                        <!-- Formulario de historias de exito -->
                        @if(is_object($oSuccessStory))
                            {!! Form::model($oSuccessStory, ['route' => ['backend.content.success-stories.update', $oSuccessStory->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'successStoryForm', 'id' => 'successStoryForm', 'files' => true]) !!}
                                {!! Form::hidden('id', $oSuccessStory->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.content.success-stories.store', 'method' => 'POST', 'name' => 'successStoryForm', 'id' => 'successStoryForm', 'class' => 'form p-t-20', 'files' => true]) !!}
                        @endif

                            <div class="form-group">
                                <label for="name"><strong>Nombre <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="success-story-name">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Ingrese el nombre de la historia de éxito', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title"><strong>Título <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="success-story-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('title', null, ['id' => 'title', 'placeholder' => 'Ingrese el título de la historia de éxito', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="url"><strong>URL <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="success-story-url">
                                            <i class="ti-world"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('url', null, ['id' => 'url', 'placeholder' => 'http://www.dominio.com/fuente-de-informacion', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="main_image">
                                    <strong>Imagen Principal: </strong><br />
                                    <small>Por favor seleccione la imagen principal de la historia de éxito que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                </label>
                                @php
                                    $dataDefaultFile = '';
                                    if(is_object($oSuccessStory)){
                                        if($oSuccessStory->main_image){
                                            $dataDefaultFile = asset($oStorage->url($oSuccessStory->main_image));
                                        }
                                    }
                                @endphp
                                {!! Form::file('main_image', ['id' => 'main_image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                            </div>

                            <div class="form-group">
                                <label for="image">
                                    <strong>Imagen Listados: </strong><br />
                                    <small>Por favor seleccione la imagen para listados de la historia de éxito que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                </label>
                                @php
                                    $dataDefaultFile = '';
                                    if(is_object($oSuccessStory)){
                                        if($oSuccessStory->image){
                                            $dataDefaultFile = asset($oStorage->url($oSuccessStory->image));
                                        }
                                    }
                                @endphp
                                {!! Form::file('image', ['id' => 'image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                            </div>

                            <div class="form-group">
                                <label for="value">
                                    <strong>
                                        Descripción
                                    </strong>
                                </label>
                                {!! Form::textarea('description', null, ['id' => 'description', 'placeholder' => 'Agregue una pequeña descripción de la historia de éxito.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="successStoryBtn" id="successStoryBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Historia de Éxito</span>
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
    {!! Html::script('backend/assets/plugins/jquery-validation/js/jquery.validate.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/jquery-validation/js/additional-methods.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/dropify/dist/js/dropify.min.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlSuccessStoriesList = '{!! route('backend.content.success-stories.list') !!}';
    </script>
    {!! Html::script('backend/assets/js/form-validate/form-validation-success-story.min.js', ['type' => 'text/javascript']) !!}
@endsection