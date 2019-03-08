@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Etapa Actual del Caso
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Etapa Actual del Caso</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item active">Etapa Actual del Caso</li>
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
                                  Lista de Etapas del Caso
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de etapas del caso generadas para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_casestages')
                                    <a href="{!! route('backend.parametrization.catalogues.case-stages.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Etapa del Caso
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($caseStagesList->isNotEmpty())
                                                @foreach($caseStagesList as $oCaseStage)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteCaseStageBtn_{!! $oCaseStage->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_casestages')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.catalogues.case-stages.edit', [$oCaseStage->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Etapa del Caso
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_casestages')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteCaseStageForm_{!! $oCaseStage->id !!}', 'deleteCaseStageBtn_{!! $oCaseStage->id !!}', 'BlaudCMS :: Etapas del Caso', 'Esta seguro que desea eliminar la etapa del caso {!! $oCaseStage->description !!}', '{!! route('backend.parametrization.catalogues.case-stages.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Etapa del Caso
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.catalogues.case-stages.delete', $oCaseStage->id], 'method' => 'DELETE', 'name' => 'deleteCaseStageForm_'.$oCaseStage->id, 'id' => 'deleteCaseStageForm_'.$oCaseStage->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oCaseStage->description !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado etapas del caso para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $caseStagesList->links() !!}
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
    {!! Html::script('public/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
@endsection