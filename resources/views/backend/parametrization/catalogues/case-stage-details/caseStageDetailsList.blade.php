@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Detalle de Etapa Actual del Caso
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Detalle de Etapa Actual del Caso</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item active">Detalle de Etapa Actual del Caso</li>
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
                                  Lista de Detalles de Etapas del Caso
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de detalles de etapas del caso generadas para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_casestagedetails')
                                    <a href="{!! route('backend.parametrization.catalogues.case-stage-details.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Detalle de Etapa del Caso
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
                                                <th>Etapa del Caso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($caseStageDetailsList->isNotEmpty())
                                                @foreach($caseStageDetailsList as $oCaseStageDetail)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteCaseStageDetailBtn_{!! $oCaseStageDetail->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_casestagedetails')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.catalogues.case-stage-details.edit', [$oCaseStageDetail->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Detalle de Etapa
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_casestagedetails')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteCaseStageDetailForm_{!! $oCaseStageDetail->id !!}', 'deleteCaseStageDetailBtn_{!! $oCaseStageDetail->id !!}', 'BlaudCMS :: Detalle de Etapas', 'Esta seguro que desea eliminar el detalle de etapa del caso {!! $oCaseStageDetail->description !!}', '{!! route('backend.parametrization.catalogues.case-stage-details.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Detalle de Etapa
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.catalogues.case-stage-details.delete', $oCaseStageDetail->id], 'method' => 'DELETE', 'name' => 'deleteCaseStageDetailForm_'.$oCaseStageDetail->id, 'id' => 'deleteCaseStageDetailForm_'.$oCaseStageDetail->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oCaseStageDetail->description !!}</td>
                                                        <td>{!! $oCaseStageDetail->superCatalogue->description !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado detalles de etapas del caso para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $caseStageDetailsList->links() !!}
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