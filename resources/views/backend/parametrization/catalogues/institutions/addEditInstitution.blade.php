@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Instituciones
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Instituciones</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.parametrization.catalogues.institutions.list') !!}">Instituciones</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oInstitution))
                            Editar Institución
                        @else
                            Agregar Institución
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
                                  @if(is_object($oInstitution))
                                    Editar Institución
                                  @else
                                    Agregar Institución
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_casestages')
                                    <a href="{!! route('backend.parametrization.catalogues.institutions.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Instituciones
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
                        @if(is_object($oInstitution))
                            {!! Form::model($oInstitution, ['route' => ['backend.parametrization.catalogues.institutions.update', $oInstitution->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'institutionForm', 'id' => 'institutionForm']) !!}
                        @else
                            {!! Form::open(['route' => 'backend.parametrization.catalogues.institutions.store', 'method' => 'POST', 'name' => 'institutionForm', 'id' => 'institutionForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            <div class="form-group">
                                <label for="description"><strong>Nombre de la Institución</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="institution-description">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('description', null, ['id' => 'description', 'placeholder' => 'Ingrese el nombre de la institución', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="institutionBtn" id="institutionBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Institución</span>
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
        var urlInstitutionList = '{!! route('backend.parametrization.catalogues.institutions.list') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-institution.min.js', ['type' => 'text/javascript']) !!}
@endsection