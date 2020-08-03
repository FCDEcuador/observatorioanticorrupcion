@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('backend/assets/css/pages/ui-bootstrap-page.css') !!}
    {!! Html::style('backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
    {!! Html::style('backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Biblioteca Legal
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Biblioteca Legal</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.legal-libraries.list') !!}">Biblioteca Legal</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oLegalLibrary))
                            Editar Artículo
                        @else
                            Agregar Artículo
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
                                  @if(is_object($oLegalLibrary))
                                    Editar Artículo
                                  @else
                                    Agregar Artículo 
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_legallibraries')
                                    <a href="{!! route('backend.content.legal-libraries.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Biblioteca Legal
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
                        @if(is_object($oLegalLibrary))
                            {!! Form::model($oLegalLibrary, ['route' => ['backend.content.legal-libraries.update', $oLegalLibrary->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'legalLibraryForm', 'id' => 'legalLibraryForm', 'files' => true]) !!}
                                {!! Form::hidden('id', $oLegalLibrary->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.content.legal-libraries.store', 'method' => 'POST', 'name' => 'legalLibraryForm', 'id' => 'legalLibraryForm', 'class' => 'form p-t-20', 'files' => true]) !!}
                        @endif

                            <div class="form-group">
                                <label for="title"><strong>Título <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="success-story-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('title', null, ['id' => 'title', 'placeholder' => 'Ingrese el título del artículo de biblioteca legal', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="issue_year"><strong>Año de Emisión <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="success-story-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::number('issue_year', null, ['id' => 'issue_year', 'placeholder' => 'Ingrese el año de emisión del artículo de biblioteca legal', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags"><strong>Tags</strong> </label>
                                {!! Form::text('tags', is_object($oLegalLibrary) ? implode(',', $oLegalLibrary->tags) : null, ['id' => 'tags', 'placeholder' => 'Agregue los tags', 'class' => 'form-control', 'data-role' => 'tagsinput']) !!}
                            </div>

                            <div class="form-group">
                                <label for="value">
                                    <strong>
                                        Descripción
                                    </strong>
                                </label>
                                {!! Form::textarea('description', null, ['id' => 'description', 'placeholder' => 'Agregue la descripción del artículo de biblioteca legal.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="image">
                                    <strong>PDF: </strong><br />
                                    <small>Por favor seleccione el archivo. Se aceptan únicamente archivos de tipo PDF.</small>
                                </label>
                                @php
                                    $dataDefaultFile = '';
                                    if(is_object($oLegalLibrary)){
                                        if($oLegalLibrary->pdf_document){
                                            $dataDefaultFile = asset($oStorage->url($oLegalLibrary->pdf_document));
                                        }
                                    }
                                @endphp
                                {!! Form::file('pdf_document', ['id' => 'pdf_document', 'class' => 'dropify', 'data-max-file-size' => '5M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                            </div>

                            

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="legalLibraryBtn" id="legalLibraryBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Biblioteca Legal</span>
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
    {!! Html::script('backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('vendor/unisharp/laravel-ckeditor/ckeditor.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlLegalLibrariesList = '{!! route('backend.content.legal-libraries.list') !!}';

        var CKEditorOptions = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={!! csrf_token() !!}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={!! csrf_token() !!}'
        };
    </script>
    {!! Html::script('backend/assets/js/form-validate/form-validation-legal-library.min.js', ['type' => 'text/javascript']) !!}
@endsection