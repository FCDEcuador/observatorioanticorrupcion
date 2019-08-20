@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Meta Tags
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Meta Tags</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.parametrization.meta-tags.list') !!}">Meta Tags</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oMetaTag))
                            Editar Meta Tag
                        @else
                            Agregar Meta Tag
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
                                  @if(is_object($oMetaTag))
                                    Editar Meta Tag
                                  @else
                                    Agregar Meta Tag
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_metatags')
                                    <a href="{!! route('backend.parametrization.meta-tags.list') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Lista de Meta Tags">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Meta Tags
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

                        <!-- Formulario de meta tags -->
                        @if(is_object($oMetaTag))
                            {!! Form::model($oMetaTag, ['route' => ['backend.parametrization.meta-tags.update', $oMetaTag->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'metaTagForm', 'id' => 'metaTagForm']) !!}
                        @else
                            {!! Form::open(['route' => 'backend.parametrization.meta-tags.store', 'method' => 'POST', 'name' => 'metaTagForm', 'id' => 'metaTagForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            <div class="form-group">
                                <label for="type"><strong>Tipo de Meta Tag</strong></label>
                                @if($oMetaTag)
                                    @php
                                        $checkName = $oMetaTag->type == 'name' ? 'checked="checked"' : '';
                                        $checkHttp = $oMetaTag->type == 'http-equiv' ? 'checked="checked"' : '';
                                    @endphp
                                    <fieldset class="controls">
                                        <label class="custom-control custom-radio">
                                            <input id="typeName" name="type" type="radio" class="custom-control-input" required {!! $checkName !!} value="name">
                                            <span class="custom-control-label">name</span>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                      <label class="custom-control custom-radio">
                                        <input type="radio" value="http-equiv" name="type" id="typeHttp" class="custom-control-input" {!! $checkHttp !!}> 
                                        <span class="custom-control-label">http-equiv</span>
                                      </label>
                                    </fieldset>
                                @else
                                    <fieldset class="controls">
                                        <label class="custom-control custom-radio">
                                            <input id="typeName" name="type" type="radio" class="custom-control-input" required checked="checked" value="name">
                                            <span class="custom-control-label">name</span>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                      <label class="custom-control custom-radio">
                                        <input type="radio" value="http-equiv" name="type" id="typeHttp" class="custom-control-input"> 
                                        <span class="custom-control-label">http-equiv</span>
                                      </label>
                                    </fieldset>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name"><strong>Nombre del Meta Tag</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="meta-tag-name">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Ingrese el valor del atributo "name" del meta tag. Ej: Keywords', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value">
                                    <strong>
                                        Valor del Meta Tag
                                    </strong>
                                </label>
                                {!! Form::textarea('value', null, ['id' => 'value', 'placeholder' => 'Coloque aqui la informacion del atributo "value" del meta tag.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="extra_attributes">
                                    <strong>
                                        Atributos extra del Meta Tag
                                    </strong>
                                </label>
                                {!! Form::textarea('extra_attributes', null, ['id' => 'extra_attributes', 'placeholder' => 'En caso de que necesite que el meta tag tenga atributos extra, coloquelos en este lugar.', 'class' => 'form-control']) !!}
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="metaTagBtn" id="metaTagBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Meta Tag</span>
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
    <script type="text/javascript">
        var urlMetaTagsList = '{!! route('backend.parametrization.meta-tags.list') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-meta-tag.min.js', ['type' => 'text/javascript']) !!}
@endsection