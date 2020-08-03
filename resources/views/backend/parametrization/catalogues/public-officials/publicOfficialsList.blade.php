@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Involucrados
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Involucrados</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item active">Involucrados</li>
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
                                  Lista de Involucrados
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de Involucrados generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-5">
                                @can('backend_add_officials')
                                    <a href="{!! route('backend.parametrization.catalogues.public-officials.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Involucrado
                                    </a>
                                @endcan
                            </div>

                            <div class="col-md-12">
                                {!! Form::open(['route' => ['backend.parametrization.catalogues.public-officials.list'], 'method' => 'POST', 'class' => 'form-horizontal', 'name' => 'searchInstitutions', 'id' => 'searchInstitutions']) !!}
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
                                            @if($publicOfficialsList->isNotEmpty())
                                                @foreach($publicOfficialsList as $oPublicOfficial)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deletePublicOfficialBtn_{!! $oPublicOfficial->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_officials')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.catalogues.public-officials.edit', [$oPublicOfficial->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Funcionario
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_officials')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deletePublicOfficialForm_{!! $oPublicOfficial->id !!}', 'deletePublicOfficialBtn_{!! $oPublicOfficial->id !!}', 'BlaudCMS :: Funcionario', 'Esta seguro que desea eliminar el funcionario {!! $oPublicOfficial->description !!}', '{!! route('backend.parametrization.catalogues.public-officials.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Funcionario
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.catalogues.public-officials.delete', $oPublicOfficial->id], 'method' => 'DELETE', 'name' => 'deletePublicOfficialForm_'.$oPublicOfficial->id, 'id' => 'deletePublicOfficialForm_'.$oPublicOfficial->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oPublicOfficial->description !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado funcionarios para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $publicOfficialsList->links() !!}
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