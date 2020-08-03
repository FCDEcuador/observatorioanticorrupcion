@extends('backend.layouts.backend-layout')

@section('custom-css')
    
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
                    <li class="breadcrumb-item active">Slider Principal</li>
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
                                  Lista de Slides
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de slides generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_mainsliders')
                                    <a href="{!! route('backend.parametrization.main-sliders.create') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Slide">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Slide
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Orden</th>
                                                <th>Imagen</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($mainSlidersList->isNotEmpty())
                                                @foreach($mainSlidersList as $oMainSlider)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteMainSliderBtn_{!! $oMainSlider->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_mainsliders')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.main-sliders.edit', [$oMainSlider->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Slide
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_mainsliders')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteMainSliderForm_{!! $oMainSlider->id !!}', 'deleteMainSliderBtn_{!! $oMainSlider->id !!}', 'BlaudCMS :: Slides', 'Esta seguro que desea eliminar este slide', '{!! route('backend.parametrization.main-sliders.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Slide
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.main-sliders.delete', $oMainSlider->id], 'method' => 'DELETE', 'name' => 'deleteMainSliderForm_'.$oMainSlider->id, 'id' => 'deleteMainSliderForm_'.$oMainSlider->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oMainSlider->order !!}</td>
                                                        <td>
                                                            @if($oMainSlider->image_path != '')
                                                                <img src="{!! asset($oStorage->url($oMainSlider->image_path)) !!}" alt="" width="400"/>
                                                            @else
                                                                <img src="{!! asset('backend/assets/images/default-thumbnail.png') !!}" alt="" width="200" />
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($oMainSlider->status === 1)
                                                                <span class="label label-success">Activo</span>
                                                            @else
                                                                <span class="label label-danger">Inactivo</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado slides para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $mainSlidersList->links() !!}
                                </div>


                            </div>
                        </div>
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
    {!! Html::script('backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
@endsection