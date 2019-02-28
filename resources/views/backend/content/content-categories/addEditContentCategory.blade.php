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
    {!! Html::style('public/backend/assets/plugins/html5-editor/bootstrap-wysihtml5.css') !!}

@endsection

@section('title')
	Contenido :: Categorías de Contenido
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Categorías de Contenido</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    @if($hasSuperContentCategory)
                      <li class="breadcrumb-item"><a href="{!! route('backend.content.content-categories.list') !!}">Categorias</a></li>
                      @if($oSuperContentCategory->content_category_id)
                        <li class="breadcrumb-item"><a href="{!! route('backend.content.content-categories.list',[$oSuperContentCategory->content_category_id]) !!}">{!! $oSuperContentCategory->superContentCategory->name !!}</a></li>
                      @endif
                      <li class="breadcrumb-item active">{!! $oSuperContentCategory->name !!}</li>
                    @else
                      <li class="breadcrumb-item active">Categorías de Contenido</li>
                    @endif
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
                                  @if($oContentCategory)
                                    Editar Categoría de Contenido
                                  @else
                                    Agregar Categoría de Contenido
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_contentcategories')
                                    <a href="{!! route('backend.content.content-categories.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Categorías de Contenido
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

                        
                        <!-- Formulario de categorias de contenido -->
                        @if(is_object($oContentCategory))
                            {!! Form::model($oContentCategory, ['route' => ['backend.content.content-categories.update', $oContentCategory->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'contentCategoryForm', 'id' => 'contentCategoryForm']) !!}
                            {!! Form::hidden('id', $oContentCategory->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.content.content-categories.store', 'method' => 'POST', 'name' => 'contentCategoryForm', 'id' => 'contentCategoryForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            @if($oSuperContentCategory)
                                <div class="form-group">
                                    <label for="content_category_id"><strong>Super Categoría de Contenido</strong></label>
                                        {!! Form::hidden('content_category_id', $oSuperContentCategory->id) !!}<br />
                                        {!! $oSuperContentCategory->name !!}
                                </div>
                            @else
                                {!! Form::hidden('content_category_id') !!}
                            @endif

                            <div class="form-group">
                                <label for="name"><strong>Nombre</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-category-name">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Ingrese el nombre de la categoría de contenido', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title"><strong>Título</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-category-title">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('title', null, ['id' => 'title', 'placeholder' => 'Ingrese el título de la categoría de contenido', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subtitle"><strong>Subtítulo</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="content-category-subtitle">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('subtitle', null, ['id' => 'subtitle', 'placeholder' => 'Ingrese el subtítulo de la categoría de contenido', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags"><strong>Tags</strong></label> <br />
                                {!! Form::text('tags', is_object($oContentCategory) ? implode(',', $oContentCategory->tags) : null, ['id' => 'tags', 'placeholder' => 'Agregue los tags', 'class' => 'form-control', 'data-role' => 'tagsinput']) !!}
                            </div>

                            <div class="form-group">
                                <label for="meta_description">
                                    <strong>
                                        Meta Description
                                    </strong>
                                </label>
                                {!! Form::textarea('meta_description', null, ['id' => 'meta_description', 'placeholder' => 'Ingrese una descripción de la categoría de contenido para manejo de posicionamiento SEO.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">
                                    <strong>
                                        Meta Keywords
                                    </strong>
                                </label>
                                {!! Form::textarea('meta_keywords', null, ['id' => 'meta_keywords', 'placeholder' => 'Ingrese las palabras clave de la categoría de contenido para manejo de posicionamiento SEO.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="extra_headers">
                                    <strong>
                                        Elementos Adicionales de Head
                                    </strong>
                                </label>
                                {!! Form::textarea('extra_headers', null, ['id' => 'extra_headers', 'placeholder' => 'En caso de necesitar agregar elementos extra como tajetas de Twitter, OpenGraph u otros elementos, los puede incluir en éste campo.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="contentCategoryBtn" id="contentCategoryBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Categoría de Contenido</span>
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
    {!! Html::script('public/backend/assets/plugins/html5-editor/wysihtml5-0.3.0.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/html5-editor/bootstrap-wysihtml5.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlContentCategoryList = '{!! route('backend.content.content-categories.list') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-content-category.min.js', ['type' => 'text/javascript']) !!}
@endsection