@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
@endsection

@section('title')
	Slider Principal
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Slider Principal</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.parametrization.main-sliders.list') !!}">Slides</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oMainSlider))
                            Editar Slide
                        @else
                            Agregar Slide
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
                                  @if(is_object($oMainSlider))
                                    Editar Slide
                                  @else
                                    Agregar Slide
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_metatags')
                                    <a href="{!! route('backend.parametrization.main-sliders.list') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Lista de Slides">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Slides
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
                        @if(is_object($oMainSlider))
                            {!! Form::model($oMainSlider, ['route' => ['backend.parametrization.main-sliders.update', $oMainSlider->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'mainSliderForm', 'id' => 'mainSliderForm']) !!}
                        @else
                            {!! Form::open(['route' => 'backend.parametrization.main-sliders.store', 'method' => 'POST', 'name' => 'mainSliderForm', 'id' => 'mainSliderForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status"> Orden de Aparición : <span class="danger">*</span> </label>
                                        {!! Form::number('order', null, ['id' => 'order', 'class' => 'custom-select form-control required', 'required']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image_path">
                                            <strong>Avatar : </strong><br />
                                            <small>Por favor seleccione la imagen a colocar en el slide. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                        </label>
                                        @php
                                            $dataDefaultFile = '';
                                            if(is_object($oMainSlider)){
                                                if($oMainSlider->image_path){
                                                    $dataDefaultFile = asset($oStorage->url($oMainSlider->image_path));
                                                }
                                            }
                                        @endphp
                                        {!! Form::file('image_path', ['id' => 'image_path', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status"> Estado : <span class="danger">*</span> </label>
                                        {!! Form::select('status', [1 => 'Activo', 0 => 'Inactivo'], null, ['id' => 'status', 'class' => 'custom-select form-control required', 'required']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="mainSliderBtn" id="mainSliderBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Slide</span>
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
    <script type="text/javascript">
        var urlMainSliderList = '{!! route('backend.parametrization.main-sliders.list') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-main-sliders.min.js', ['type' => 'text/javascript']) !!}
@endsection