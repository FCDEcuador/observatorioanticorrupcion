@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('backend/assets/plugins/select2/dist/css/select2.min.css') !!}
    {!! Html::style('backend/assets/plugins/bootstrap-select/bootstrap-select.min.css') !!}
    {!! Html::style('backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Detalle de Etapa del Caso
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Detalle de Etapa del Caso</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.parametrization.catalogues.case-stages.list') !!}">Detalle de Etapa</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oCaseStageDetail))
                            Editar Etapa del Caso
                        @else
                            Agregar Etapa del Caso
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
                                  @if(is_object($oCaseStageDetail))
                                    Editar Detalle de Etapa
                                  @else
                                    Agregar Detalle Etapa
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_casestages')
                                    <a href="{!! route('backend.parametrization.catalogues.case-stage-details.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Detalles de Etapa del Caso
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
                        @if(is_object($oCaseStageDetail))
                            {!! Form::model($oCaseStageDetail, ['route' => ['backend.parametrization.catalogues.case-stage-details.update', $oCaseStageDetail->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'caseStageDetailForm', 'id' => 'caseStageDetailForm']) !!}
                        @else
                            {!! Form::open(['route' => 'backend.parametrization.catalogues.case-stage-details.store', 'method' => 'POST', 'name' => 'caseStageDetailForm', 'id' => 'caseStageDetailForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            <div class="form-group">
                                <label for="catalogue_id"><strong>Etapa del Caso</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="province-description">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::select('catalogue_id', $aCaseStageList, null, ['id' => 'catalogue_id', 'placeholder' => 'Seleccione la Etapa del Caso', 'class' => 'select2 form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description"><strong>Nombre del Detalle de Etapa</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="province-description">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('description', null, ['id' => 'description', 'placeholder' => 'Ingrese el nombre del detalle de la etapa', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="caseStageDetailBtn" id="caseStageDetailBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Detalle de Etapa del Caso</span>
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
    {!! Html::script('backend/assets/plugins/select2/dist/js/select2.full.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/bootstrap-select/bootstrap-select.min.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlCaseStageDetailsList = '{!! route('backend.parametrization.catalogues.case-stage-details.list') !!}';
    </script>
    {!! Html::script('backend/assets/js/form-validate/form-validation-case-stage-detail.min.js', ['type' => 'text/javascript']) !!}
@endsection