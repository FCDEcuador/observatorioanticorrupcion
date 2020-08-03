@extends('backend.layouts.backend-layout')

@section('custom-css')
    
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
                <h3 class="text-themecolor">Función del Estado</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item active">Instituciones</li>
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
                                  Lista de Instituciones
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de instituciones generadas para el portal web
                                </h6>
                            </div>
                            <div class="col-md-5">
                                @can('backend_add_casestages')
                                    <a href="{!! route('backend.parametrization.catalogues.institutions.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Institución
                                    </a>
                                @endcan
                            </div>

                            <div class="col-md-12">
                                {!! Form::open(['route' => ['backend.parametrization.catalogues.institutions.list'], 'method' => 'POST', 'class' => 'form-horizontal', 'name' => 'searchInstitutions', 'id' => 'searchInstitutions']) !!}
                                  <div class="form-group">
                                    <h5>Buscar Por:</h5>
                                    <div class="controls">
                                      {!! Form::text('sStringSearch', old('sStringSearch'), ['class' => 'form-control', 'placeholder' => 'NOMBRE', 'id' => 'sStringSearch']) !!}
                                    </div>
                                  </div>
                                  <div class="text-xs-right">
                                      {!! Form::submit('Buscar', ['class' => 'btn btn-info']) !!}
                                  </div>
                                {!! Form::close() !!}
                                <hr />
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
                                            @if($institutionsList->isNotEmpty())
                                                @foreach($institutionsList as $oInstitution)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteInstitutionBtn_{!! $oInstitution->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_institutions')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.catalogues.institutions.edit', [$oInstitution->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Institución
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_institutions')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteInstitutionForm_{!! $oInstitution->id !!}', 'deleteInstitutionBtn_{!! $oInstitution->id !!}', 'BlaudCMS :: Instituciones', 'Esta seguro que desea eliminar la institución {!! $oInstitution->description !!}', '{!! route('backend.parametrization.catalogues.institutions.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Institución
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.catalogues.institutions.delete', $oInstitution->id], 'method' => 'DELETE', 'name' => 'deleteInstitutionForm_'.$oInstitution->id, 'id' => 'deleteInstitutionForm_'.$oInstitution->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oInstitution->description !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado instituciones para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $institutionsList->links() !!}
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