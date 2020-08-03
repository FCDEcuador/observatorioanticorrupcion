@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Casos de Corrupción
@endsection

@section('main-content')	
	
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Casos de Corrupción</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item active">Casos de Corrupcion</li>
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
                                  Lista de Casos de Corrupción
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de casos de corrupción generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_corruptioncases')
                                    <a href="{!! route('backend.content.corruption-cases.create') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Caso de Corrupción">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Caso de Corrupción
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Titulo</th>
                                                <th>Etapa Actual del Caso</th>
                                                <th>Detalle sobre la Etapa</th>
                                                <th>Función del Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($corruptionCasesList->isNotEmpty())
                                                @foreach($corruptionCasesList as $oCorruptionCase)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteCorruptionCaseBtn_{!! $oCorruptionCase->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_delete_corruptioncases')
                                                                        {!! Form::open(['route' => ['backend.content.corruption-cases.delete', $oCorruptionCase->id], 'method' => 'DELETE', 'name' => 'deleteCorruptionCaseForm_'.$oCorruptionCase->id, 'id' => 'deleteCorruptionCaseForm_'.$oCorruptionCase->id]) !!}
                                                                    @endcan
                                                                    @can('backend_edit_corruptioncases')
                                                                        <a class="btn btn-xs btn-info waves-effect waves-light text-white" href="{!! route('backend.content.corruption-cases.edit', [$oCorruptionCase->id]) !!}" style="width:90%;margin-left:8px;">
                                                                            <span class="btn-label"><i class="mdi mdi-pencil"></i></span>
                                                                            Editar Caso de Corrupción
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                    @endcan
                                                                    @can('backend_delete_corruptioncases')
                                                                        <button class="btn btn-xs btn-danger waves-effect waves-light text-white" type="button" onclick="javascript: confirmDelete('deleteCorruptionCaseForm_{!! $oCorruptionCase->id !!}', 'deleteCorruptionCaseBtn_{!! $oCorruptionCase->id !!}', 'BlaudCMS :: Casos de Corrupción', 'Esta seguro que desea eliminar el caso de corrupción {!! $oCorruptionCase->title !!}', '{!! route('backend.content.corruption-cases.list') !!}', true);" style="cursor:pointer;width:90%;margin:8px;">
                                                                            <span class="btn-label"><i class="mdi mdi-delete"></i></span>
                                                                            Eliminar Caso de Corrupción
                                                                        </button>
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oCorruptionCase->title !!}</td>
                                                        <td>{!! $oCorruptionCase->case_stage !!}</td>
                                                        <td>{!! $oCorruptionCase->case_stage_detail !!}</td>
                                                        <td>{!! $oCorruptionCase->state_function !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="6">Aun no se han generado casos de corrupción en el sistema.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $corruptionCasesList->links() !!}
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