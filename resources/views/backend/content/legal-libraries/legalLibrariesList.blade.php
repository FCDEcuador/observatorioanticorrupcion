@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Biblioteca Legal
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Biblioteca Legal</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item active">Biblioteca Legal</li>
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
                                  Lista de Artículos
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de artículos de biblioteca legal generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_legallibraries')
                                    <a href="{!! route('backend.content.legal-libraries.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Artículo
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Título</th>
                                                <th>Año</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($legalLibrariesList->isNotEmpty())
                                                @foreach($legalLibrariesList as $oLegalLibrary)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteLegalLibraryBtn_{!! $oLegalLibrary->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_legallibraries')
                                                                        <a class="dropdown-item" href="{!! route('backend.content.legal-libraries.edit', [$oLegalLibrary->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Artículo
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_legallibraries')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteLegalLibraryForm_{!! $oLegalLibrary->id !!}', 'deleteLegalLibraryBtn_{!! $oLegalLibrary->id !!}', 'BlaudCMS :: Historias de Exito', 'Esta seguro que desea eliminar la historia de éxito {!! $oLegalLibrary->name !!}', '{!! route('backend.content.legal-libraries.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Artículo
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.content.legal-libraries.delete', $oLegalLibrary->id], 'method' => 'DELETE', 'name' => 'deleteLegalLibraryForm_'.$oLegalLibrary->id, 'id' => 'deleteLegalLibraryForm_'.$oLegalLibrary->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oLegalLibrary->title !!}</td>
                                                        <td>{!! $oLegalLibrary->issue_year !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="3">Aun no se han generado artículos de biblioteca legal para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $legalLibrariesList->links() !!}
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