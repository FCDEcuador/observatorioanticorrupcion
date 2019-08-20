@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/wizard/steps.css') !!}
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}

    <!-- page CSS -->
    {!! Html::style('public/backend/assets/plugins/select2/dist/css/select2.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-select/bootstrap-select.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') !!}

@endsection

@section('title')
	Contenido :: Artículos de Contenido
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Artículos de Contenido</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item">
                        <a href="{!! route('backend.content.content-categories.list') !!}">
                            Categorías de Contenido
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{!! route('backend.content.content-articles.list') !!}">
                            Artículos de Contenido
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oContentArticle))
                            Editar Artículo de Contenido
                        @else
                            Agregar Artículo de Contenido
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
        <div class="row" id="validation">
            <div class="col-12">
                <div class="card wizard-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">
                                  @if(is_object($oContentArticle))
                                    Editar Artículo de Contenido
                                  @else
                                    Agregar Artículo de Contenido
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_contentarticles')
                                    <a href="{!! route('backend.content.content-articles.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Artículos de Contenido
                                    </a>
                                @endcan
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
                        </div>

                        
                        <!-- Formulario de usuarios -->
                        @if(is_object($oContentArticle))
                            {!! Form::model($oContentArticle, ['route' => ['backend.content.content-articles.update', $oContentArticle->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'contentArticleForm', 'id' => 'contentArticleForm', 'files' => true]) !!}
                            {!! Form::hidden('id', $oContentArticle->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.content.content-articles.store', 'method' => 'POST', 'name' => 'contentArticleForm', 'id' => 'contentArticleForm', 'class' => 'form p-t-20', 'files' => true]) !!}
                        @endif

                            <div class="form-group">
                                <label for="content_category_id"><strong>Categoría <span class="text-danger">*</span></strong></label>
                                <select name="content_category_id" id="content_category_id" class="select2 form-control" required>
                                    <option value="" selected="selected">Seleccione una categoría de contenido ....</option>
                                    {!! BlaudCMS\ContentCategory::dropDownItems(null, $sContentCategoryId) !!}
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title"><strong>Título <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-article-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('title', null, ['id' => 'title', 'placeholder' => 'Ingrese el título del artículo de contenido', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="outstanding"><strong>Es Destacado?</strong></label>
                                {!! Form::select('outstanding', [0 => 'NO', 1 => 'SI'], null, ['id' => 'outstanding', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="summary"><strong>Resumen <span class="danger">*</span></strong></label>
                                {!! Form::textarea('summary', null, ['id' => 'summary', 'placeholder' => 'Ingrese el resumen del artículo de contenido, máximo 1 párrafo', 'class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                <label for="content"><strong>Contenido</strong></label>
                                {!! Form::textarea('content', null, ['id' => 'content', 'class' => 'form-control', 'placeholder' => 'Ingrese el contenido completo del artículo de contenido.']) !!}
                            </div>

                            <div class="form-group">
                                <label for="author"><strong>Autor</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-article-author">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('author', null, ['id' => 'author', 'placeholder' => 'Ingrese el autor del artículo de contenido', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="author_email"><strong>Email del Autor</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-article-author_email">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::email('author_email', null, ['id' => 'author_email', 'placeholder' => 'Ingrese el autor del artículo de contenido', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="source"><strong>Fuente</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-article-source">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('source', null, ['id' => 'source', 'placeholder' => 'Ingrese el autor del artículo de contenido', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags"><strong>Tags</strong> </label>
                                {!! Form::text('tags', is_object($oContentArticle) ? implode(',', $oContentArticle->tags) : null, ['id' => 'tags', 'placeholder' => 'Agregue los tags', 'class' => 'form-control', 'data-role' => 'tagsinput']) !!}
                            </div>

                            <div class="form-group">
                                <label for="main_multimedia">
                                    <strong>Imagen Principal : </strong><br />
                                    <small>Por favor seleccione la imagen principal del caso de corrupción que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                </label>
                                @php
                                    $dataDefaultFile = '';
                                    if(is_object($oContentArticle)){
                                        if($oContentArticle->main_multimedia){
                                            $dataDefaultFile = asset($oStorage->url($oContentArticle->main_multimedia));
                                        }
                                    }
                                @endphp
                                {!! Form::file('main_multimedia', ['id' => 'main_multimedia', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                            </div>

                            <div class="form-group">
                                <label for="meta_description"><strong>Meta Description</strong></label>
                                {!! Form::textarea('meta_description', null, ['id' => 'meta_description', 'placeholder' => 'Ingrese la descripcion del articulo para posicionamiento SEO', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords"><strong>Meta Keywords</strong></label>
                                {!! Form::textarea('meta_keywords', null, ['id' => 'meta_keywords', 'placeholder' => 'Ingrese las palabras clave del artículo para posicionamiento SEO', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="extra_headers"><strong>Atributos Extra</strong></label>
                                {!! Form::textarea('extra_headers', null, ['id' => 'extra_headers', 'placeholder' => 'En caso de requerirlo, en esta caja de texto puede incluir elementos como twitter cards, opengraph, etc.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="contentArticleBtn" id="contentArticleBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Artículo de Contenido</span>
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
    {!! Html::script('public/backend/assets/plugins/wizard/jquery.steps.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/dropify/dist/js/dropify.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/switchery/dist/switchery.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/select2/dist/js/select2.full.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-select/bootstrap-select.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js', ['type' => 'text/javascript']) !!}
    <!-- wysuhtml5 Plugin JavaScript -->
    {!! Html::script('public/vendor/unisharp/laravel-ckeditor/ckeditor.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlContentArticlesList = '{!! route('backend.content.content-articles.list') !!}';

        var CKEditorOptions = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={!! csrf_token() !!}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={!! csrf_token() !!}'
        };
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-content-articles.min.js', ['type' => 'text/javascript']) !!}
@endsection